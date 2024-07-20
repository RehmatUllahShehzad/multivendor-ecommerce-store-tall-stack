<?php

namespace App\Http\Livewire\Frontend\Vendor\PaymentHistory;

use App\DTO\Payments\AccountLink;
use App\DTO\Payments\CardAccount;
use App\Managers\PaymentManager;
use App\Models\WithdrawAccount;
use Exception;
use Illuminate\Support\Facades\Auth;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;

class AttachDebitCardController extends PaymentHistoryAbstract
{
    public string $name = '';

    public string $card_number = '';

    public string $exp_year = '';

    public string $exp_month = '';

    public string $cvc = '';

    public string $first_address = '';

    public string $second_address = '';

    public string $city = '';

    public string $zipcode = '';

    public function rules()
    {
        return  [
            'name' => 'bail|required',
            'card_number' => 'bail|required',
            'exp_year' => ['bail', 'required', new CardExpirationYear($this->exp_month)],
            'exp_month' => ['bail', 'required', new CardExpirationMonth($this->exp_year)],
            'cvc' => 'bail|required',

            'first_address' => 'bail|required',
            'second_address' => 'bail|required',
            'city' => 'bail|required',
            'zipcode' => 'bail|required',
        ];
    }

    public function submit()
    {

        $this->validate();

        try {

            $paymentManager = app(PaymentManager::class);

            $params = new CardAccount(
                name_on_card: $this->name,
                card_number: $this->card_number,
                month: $this->exp_month,
                year: $this->exp_year,
                cvc: $this->cvc,
                first_address: $this->first_address,
                second_address: $this->second_address,
            );

            $response = $paymentManager->driver('stripe')->createAccount($params);

            $stripe_id = $response->data->id;

            $card_number = substr($this->card_number, -4);

            $meta = [
                'object' => 'card', 'name' => $this->name,
                'exp_month' => $this->exp_month, 'exp_year' => $this->exp_year,
                'last4' => $card_number, 'city' => $this->city, 'zipcode' => $this->zipcode,
            ];

            WithdrawAccount::updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'id' => Auth::user()->id,
                    'meta' => $meta,
                    'stripe_id' => $stripe_id,
                ],
            );

            $links = new AccountLink(
                return_url: route('vendor.payment.history.index'),
                refresh_url: url()->previous()
            );

            $response = $paymentManager->driver('stripe')->createAccountLink($stripe_id, $links);

            return redirect($response->data->account_links->url);
        } catch (\Stripe\Exception\CardException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return $this->emit('alert-danger', $e->getError()->message);
        } catch (Exception $e) {
            return $this->emit('alert-danger', $e->getMessage());
        }
    }

    public function render()
    {
        return $this->view('frontend.vendor.payment-history.attach-debit-card-controller');
    }
}
