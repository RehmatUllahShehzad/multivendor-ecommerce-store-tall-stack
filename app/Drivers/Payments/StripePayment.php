<?php

namespace App\Drivers\Payments;

use App\Contracts\PaymentProcessor;
use App\DTO\Payments\Account as AccountDto;
use App\DTO\Payments\AccountLink as PaymentsAccountLink;
use App\DTO\Payments\BankAccount;
use App\DTO\Payments\CardAccount;
use App\DTO\Payments\Customer as CustomerDto;
use App\DTO\Payments\PaymentMethod;
use App\DTO\Payments\PaymentWithdraw;
use App\DTO\Payments\Withdraw;
use App\DTO\Response;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod as ModelsPaymentMethod;
use App\Models\Transaction;
use App\Services\Cart\Actions\CreateVendorOrderTransaction;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Account;
use Stripe\AccountLink;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod as StripePaymentMethod;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Transfer;
use Throwable;

class StripePayment implements PaymentProcessor
{
    /**
     * The Stripe instance.
     *
     * @var \Stripe\StripeClient
     */
    protected $stripe;

    /**
     * The instance of the cart.
     *
     * @var \App\Models\Cart
     */
    protected ?Cart $cart = null;

    /**
     * The instance of the order.
     *
     * @var \App\Models\Order
     */
    protected ?Order $order = null;

    /**
     * The Payment intent.
     *
     * @var PaymentIntent
     */
    protected PaymentIntent $paymentIntent;

    /**
     * The policy when capturing payments.
     *
     * @var string
     */
    protected $policy;

    /**
     * Any config for this payment provider.
     *
     * @var array
     */
    protected array $config = [];

    public function __construct()
    {
        $this->stripe = $this->getClient();

        $this->policy = config('stripe.policy', 'automatic');

        Stripe::setApiKey(config('services.stripe.key'));
    }

    /**
     * Return the Stripe client
     *
     * @return void
     */
    public function getClient()
    {
        return new StripeClient(
            config('services.stripe.key')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function cart(Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function order(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function withData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public static function createAccount(CardAccount $cardAccountDto)
    {
        $mytime = now()->timestamp;

        $response = Account::create([
            'tos_acceptance' => ['date' => $mytime, 'ip' => request()->ip()],
            'type' => 'custom',
            'country' => 'US',
            'capabilities' => [
                'card_payments' => ['requested' => true],
                'transfers' => ['requested' => true],
            ],
            'business_type' => 'individual',
            'external_account' => [
                'object' => 'card',
                'name' => $cardAccountDto->name_on_card,
                'number' => $cardAccountDto->card_number,
                'country' => 'US',
                'exp_month' => $cardAccountDto->month,
                'exp_year' => $cardAccountDto->year,
                'cvc' => $cardAccountDto->cvc,
                'currency' => 'usd',
                'address_line1' => $cardAccountDto->first_address,
                'address_line2' => $cardAccountDto->second_address,
                'default_for_currency' => true,
            ],
        ]);

        return new Response(
            success: true,
            message: 'Stripe Account created successfully',
            data: new AccountDto(
                id: $response->id,
            ),
        );
    }

    public static function createBankAccount(BankAccount $bankAccountDto)
    {
        $response = Account::create([
            'business_type' => 'individual',
            'type' => 'standard',
            'country' => 'US',
            'external_account' => [
                'object' => 'bank_account',
                'account_holder_name' => $bankAccountDto->account_holder_name,
                'account_holder_type' => 'individual',
                'country' => 'US',
                'currency' => 'usd',
                'account_number' => $bankAccountDto->account_number,
                'routing_number' => '110000000',
            ],
        ]);

        return new Response(
            success: true,
            message: 'Stripe Account created successfully',
            data: new AccountDto(
                id: $response->id,
            ),
        );
    }

    public static function createAccountLink($stripeAccountId, PaymentsAccountLink $links)
    {
        $response = AccountLink::create([
            'account' => $stripeAccountId,
            'refresh_url' => $links->refresh_url ?? '',
            'return_url' => $links->return_url ?? '',
            'type' => 'account_onboarding',
        ]);

        return new Response(
            success: true,
            message: 'Stripe customer created successfully',
            data: new AccountDto(
                account_links: $response,
            ),
        );
    }

    public static function withdrawAmount(Withdraw $withdraw): Response
    {
        $response = Transfer::create([
            'amount' => $withdraw->amount * 100,
            'destination' => $withdraw->destination,
            'currency' => 'usd',
        ]);

        return new Response(
            success: true,
            message: 'Amount withdrawn successfully',
            data: new PaymentWithdraw(
                response: $response,
            ),
        );
    }

    public static function getVendor($stripeAccountId)
    {
        return Account::retrieve($stripeAccountId);
    }

    /**
     * Returns Customer
     *
     * Create Stripe Customer
     */
    public function createCustomer(CustomerDto $customer): Response
    {
        $response = Customer::create([
            'email' => $customer->email,
            'name' => $customer->name,
        ]);

        return new Response(
            success: true,
            message: 'Stripe customer created successfully',
            data: new CustomerDto(
                id: $response->id,
                name: $response->name,
                email: $response->email,
            ),
        );
    }

    /**
     *  Returns a PaymentMethod object.
     *
     * Create a Card
     */
    public function createPaymentMethod(PaymentMethod $card, string $customerId = null): Response
    {
        try {
            $paymentMethod = StripePaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $card->cardNumber,
                    'exp_month' => $card->expMonth,
                    'exp_year' => $card->expYear,
                    'cvc' => $card->cvc,
                ],
                'billing_details' => [
                    'name' => $card->name,
                ],
            ]);

            if (! $customerId) {
                return new Response(
                    success: true,
                    message: 'Payment Method created successfully',
                    data: $this->stripeResponseToPaymentDto($paymentMethod),
                );
            }

            return $this->attachPaymentMethod($customerId, $paymentMethod);
        } catch (Throwable $e) {
            return new Response(
                success: false,
                message: $e->getMessage(),
            );
        }
    }

    /**
     *  Returns a PaymentMethod object.
     *
     * Attach a Customer
     */
    public function attachPaymentMethod(string $customerId, StripePaymentMethod $paymentMethod): Response
    {
        try {
            $response = $paymentMethod->attach(
                ['customer' => $customerId]
            );

            return new Response(
                success: true,
                message: 'Payment Method created successfully',
                data: $this->stripeResponseToPaymentDto($response),
            );
        } catch (Exception $e) {
            return new Response(
                success: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * Returns a PaymentMethod object.
     *
     * Retrieve a payment method
     */
    public function getPaymentMethod(string $paymentMethodId): Response
    {
        try {
            $response = StripePaymentMethod::retrieve($paymentMethodId);

            if (! $response->id) {
                return new Response(
                    success: false,
                    message: 'PaymentId does not exists',
                    data: $this->stripeResponseToPaymentDto($response),
                );
            }

            return new Response(
                success: true,
                message: 'Payment Method!',
                data: $this->stripeResponseToPaymentDto($response),
            );
        } catch (Exception $e) {
            return new Response(
                success: false,
                message: $e->getMessage()
            );
        }
    }

    /** Returns a PaymentMethod object.
     *
     * Detach a customer
     */
    public function deletePaymentMethod(string $paymentMethodId): Response
    {
        try {
            $response = StripePaymentMethod::retrieve($paymentMethodId)->detach();

            if ($response->customer != null) {
                throw new Exception('Something Went Wrong', 500);
            }

            return new Response(
                success: true,
                message: 'Customer detach successfully!',
                data: $this->stripeResponseToPaymentDto($response),
            );
        } catch (Exception $e) {
            return new Response(
                success: false,
                message: $e->getMessage()
            );
        }
    }

    /**
     * will take stripe payment method response
     *
     *
     *return the payment method DTO response
     */
    private function stripeResponseToPaymentDto(StripePaymentMethod $paymentMethod): PaymentMethod
    {
        return new PaymentMethod(
            id: $paymentMethod->id,
            name: $paymentMethod->billing_details->name,
            /** @phpstan-ignore-line */
            cardNumber: $paymentMethod->card->last4,
            /** @phpstan-ignore-line */
            expMonth: $paymentMethod->card->exp_month,
            /** @phpstan-ignore-line */
            expYear: $paymentMethod->card->exp_year
        /** @phpstan-ignore-line */
        );
    }

    /**
     * Create an intent from cart and add card payment method
     *
     * @param  \App\Models\Cart  $cart
     * @param  array  $card
     * @return \Stripe\PaymentIntent
     */
    public function createIntentWithCard(Cart $cart, string $paymentMethodId)
    {
        return $this->addCardToIntent(
            $this->createIntent($cart),
            $paymentMethodId
        );
    }

    /**
     * Add card payment method to intent
     *
     * @param  \Stripe\PaymentIntent  $intent
     * @param  array  $card
     * @return \Stripe\PaymentIntent
     */
    protected function addCardToIntent(PaymentIntent $intent, string $paymentMethodId)
    {
        return $intent->update($intent->id, [
            'payment_method' => $paymentMethodId,
            'customer' => Auth::user()->stripe_customer_id,
        ]);
    }

    /**
     * Create a payment intent from a Cart
     *
     * @param  Cart  $cart
     * @return \Stripe\PaymentIntent
     */
    public function createIntent(Cart $cart)
    {
        $meta = $cart->meta;
        if ($meta && $meta->payment_method_id) {
            $intent = $this->fetchIntent(
                $meta->payment_method_id
            );

            if ($intent) {
                return $intent;
            }
        }

        $shipping = $cart->shippingAddress;

        $paymentIntent = $this->buildIntent(
            ($cart->subTotal + $cart->shippingTotal),
            $shipping,
        );

        if (! $meta) {
            $cart->update([
                'meta' => [
                    'payment_intent_id' => $paymentIntent->id,
                ],
            ]);
        } else {
            $meta->payment_intent_id = $paymentIntent->id;
            $cart->meta = $meta;
            $cart->save();
        }

        return $paymentIntent;
    }

    /**
     * Fetch an intent from the Stripe API.
     *
     * @param  string  $intentId
     * @return null|\Stripe\PaymentIntent
     */
    public function fetchIntent($intentId)
    {
        try {
            $intent = PaymentIntent::retrieve($intentId);
        } catch (Exception $e) {
            return;
        }

        return $intent;
    }

    /**
     * Build the intent
     *
     * @param  int  $value
     * @param  \App\Models\CartAddress  $shipping
     * @return \Stripe\PaymentIntent
     */
    protected function buildIntent($value, $shipping)
    {
        return PaymentIntent::create([
            'amount' => $value * 100,
            'payment_method_types' => ['card'],
            'currency' => 'usd',
            'capture_method' => config('stripe.policy', 'automatic'),
            'shipping' => [
                'name' => "{$shipping->first_name} {$shipping->last_name}",
                'address' => [
                    'city' => $shipping->city,
                    'country' => $shipping->country->iso2,
                    'line1' => $shipping->address_1,
                    'line2' => $shipping->address_2,
                    'postal_code' => $shipping->zip,
                    'state' => $shipping->state->name,
                ],
            ],
        ]);
    }

    /**
     * Authorize the payment for processing.
     *
     * @return \App\DTO\Response
     */
    public function authorize(): Response
    {
        if (! $this->order) {
            if (! $this->order = $this->cart->order) {
                $this->order = $this->cart->getManager()->createOrder();
            }
        }

        $this->paymentIntent = $this->stripe->paymentIntents->retrieve(
            $this->data['payment_intent']
        );

        if ($this->paymentIntent->status == 'requires_confirmation') {
            $this->paymentIntent->confirm();
        }

        if ($this->paymentIntent->status == 'requires_capture' && $this->policy == 'automatic') {
            $this->paymentIntent = $this->stripe->paymentIntents->capture(
                $this->data['payment_intent']
            );
        }

        if ($this->cart) {
            if (! $this->cart->meta) {
                $this->cart->update([
                    'meta' => [
                        'payment_intent' => $this->paymentIntent->id,
                    ],
                ]);
            } else {
                $this->cart->meta->payment_intent = $this->paymentIntent->id;
                $this->cart->meta = $this->cart->meta;
                $this->cart->save();
            }
        }

        if (! in_array($this->paymentIntent->status, [
            'processing',
            'requires_capture',
            'succeeded',
        ])) {
            return new Response(
                success: false,
                message: $this->paymentIntent->last_payment_error,
            );
        }

        return $this->releaseSuccess();
    }

    /**
     * Capture a payment for a transaction.
     *
     * @param  \GetCandy\Models\Transaction  $transaction
     * @param  int  $amount
     * @return \App\DTO\Response
     */
    public function capture(Transaction $transaction, $amount = 0): Response
    {
        $payload = [];

        if ($amount > 0) {
            $payload['amount_to_capture'] = $amount;
        }

        try {
            $response = $this->stripe->paymentIntents->capture(
                $transaction->reference,
                $payload
            );
        } catch (Exception $e) {
            return new Response(
                success: false,
                message: $e->getMessage()
            );
        }

        $charges = $response->charges->data;

        $transactions = [];
        foreach ($charges as $charge) {
            $card = $charge->payment_method_details->card;
            $transactions[] = [
                'parent_transaction_id' => $transaction->id,
                'success' => $charge->status != 'failed',
                'type' => 'capture',
                'driver' => 'stripe',
                'amount' => $charge->amount_captured,
                'reference' => $response->id,
                'status' => $charge->status,
                'notes' => $charge->failure_message,
                'card_type' => $card->brand,
                'last_four' => $card->last4,
                'captured_at' => $charge->amount_captured ? now() : null,
            ];
        }

        $transaction->order->transactions()->createMany($transactions);

        return new Response(success: true);
    }

    /**
     * Refund a captured transaction
     *
     * @param  \App\Models\Transaction  $transaction
     * @param  int  $amount
     * @param  string|null  $notes
     * @return \App\DTO\PaymentRefund
     */
    public function refund(Transaction $transaction, int $amount = 0, $notes = null): Response
    {
        try {
            $refund = $this->stripe->refunds->create(
                ['payment_intent' => $transaction->reference, 'amount' => $amount]
            );
        } catch (Exception $e) {
            return new Response(
                success: false,
                message: $e->getMessage()
            );
        }

        $transaction->order->transactions()->create([
            'success' => $refund->status != 'failed',
            'type' => 'refund',
            'driver' => 'stripe',
            'amount' => $refund->amount,
            'reference' => $refund->payment_intent,
            'status' => $refund->status,
            'notes' => $notes,
            'card_type' => $transaction->card_type,
            'last_four' => $transaction->last_four,
        ]);

        return new Response(
            success: true
        );
    }

    /**
     * Return a successfully released payment.
     *
     * @return void
     */
    private function releaseSuccess()
    {
        DB::transaction(function () {

            // Get our first successful charge.
            $charges = $this->paymentIntent->charges->data;

            $successCharge = collect($charges)->first(function ($charge) {
                return ! $charge->refunded && ($charge->status == 'succeeded' || $charge->status == 'paid');
            });

            $this->order->update([
                'created_at' => now()->parse($successCharge->created),
            ]);

            $type = 'capture';

            if ($this->policy == 'manual') {
                $type = 'intent';
            }

            $paymentMethod = ModelsPaymentMethod::where('payment_method_id', $this->paymentIntent->payment_method)->first();

            $card = $successCharge->payment_method_details->card;

            $transaction = $this->order->transactions()->create([
                'success' => $successCharge->status != 'failed',
                'type' => $successCharge->amount_refunded ? 'refund' : $type,
                'driver' => 'stripe',
                'amount' => ($successCharge->amount) / 100,
                'reference' => $this->paymentIntent->id,
                'status' => $successCharge->status,
                'notes' => $successCharge->failure_message,
                'card_type' => $card->brand,
                'last_four' => $card->last4,
                'name_on_card' => $paymentMethod->name,
                'expiry_month' => $card->exp_month,
                'expiry_year' => $card->exp_year,
                'meta' => [
                    'address_line1_check' => $card->checks->address_line1_check,
                    'address_postal_code_check' => $card->checks->address_postal_code_check,
                    'cvc_check' => $card->checks->cvc_check,
                ],
            ]);

            app(CreateVendorOrderTransaction::class)->execute($this->order, $transaction);
        });

        return new Response(success: true);
    }
}
