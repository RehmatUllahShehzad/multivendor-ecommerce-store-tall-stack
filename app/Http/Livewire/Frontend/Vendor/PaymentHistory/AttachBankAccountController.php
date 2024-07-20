<?php

namespace App\Http\Livewire\Frontend\Vendor\PaymentHistory;

use App\DTO\Payments\AccountLink;
use App\DTO\Payments\BankAccount;
use App\Managers\PaymentManager;
use App\Models\WithdrawAccount;
use Exception;
use Illuminate\Support\Facades\Auth;

class AttachBankAccountController extends PaymentHistoryAbstract
{
    public string $name = '';

    public string $account_number = '';

    public string $account_type = '';

    public string $country = '';

    public function rules()
    {
        return  [
            'name' => 'bail|required',
            'account_number' => 'bail|required',
            'country' => 'bail|required',
            'account_type' => 'bail|required',
        ];
    }

    public function submit()
    {
        $this->validate();

        try {
            $paymentManager = app(PaymentManager::class);

            $params = new BankAccount(
                account_holder_name: $this->name,
                account_number: $this->account_number,
            );

            $response = $paymentManager->driver('stripe')->createBankAccount($params);

            $stripe_id = $response->data->id;

            WithdrawAccount::updateOrCreate(
                ['id' => Auth::user()->id],
                [
                    'id' => Auth::user()->id,
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
        return $this->view('frontend.vendor.payment-history.attach-bank-account-controller');
    }
}
