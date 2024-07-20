<?php

namespace App\Contracts;

use App\DTO\Payments\Customer;
use App\DTO\Payments\PaymentMethod;
use App\DTO\Response;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;

interface PaymentProcessor
{
    /**
     * Returns Customer
     *
     * Create Stripe Customer
     */
    public function createCustomer(Customer $customer): Response;

    /**
     *  Returns a PaymentMethod object.
     *
     * Create a Card
     */
    public function createPaymentMethod(PaymentMethod $paymentMethod, string $customerId = null): Response;

    /**
     * Returns a PaymentMethod object.
     *
     * Retrieve a payment method
     */
    public function getPaymentMethod(string $paymentMethodId): Response;

    /** Returns a PaymentMethod object.
     *
     * Detach a customer
     */
    public function deletePaymentMethod(string $paymentMethodId): Response;

    /**
     * Set the cart.
     *
     * @param  \GetCandy\Models\Cart  $order
     * @return self
     */
    public function cart(Cart $cart): self;

    /**
     * Set the order.
     *
     * @param  Order  $order
     * @return self
     */
    public function order(Order $order): self;

    /**
     * Set any data the provider might need.
     *
     * @param  array  $data
     * @return self
     */
    public function withData(array $data): self;

    /**
     * Set any configuration on the driver.
     *
     * @param  array  $config
     * @return self
     */
    public function setConfig(array $config): self;

    /**
     * Authorize the payment.
     *
     * @return void
     */
    public function authorize(): Response;

    /**
     * Refund a transaction for a given amount.
     *
     * @param  \GetCandy\Models\Transaction  $transaction
     * @param  int  $amount
     * @param  null|string  $notes
     * @return \App\DTO\Response
     */
    public function refund(Transaction $transaction, int $amount, $notes = null): Response;

    /**
     * Capture an amount for a transaction.
     *
     * @param  \App\Models\Transaction  $transaction
     * @param  int  $amount
     * @return \App\DTO\Response
     */
    public function capture(Transaction $transaction, $amount = 0): Response;
}
