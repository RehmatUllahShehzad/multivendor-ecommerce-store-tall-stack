<?php

namespace App\Http\Livewire\Frontend\Vendor\PaymentHistory;

use App\DTO\Payments\Withdraw;
use App\Enums\TransactionStatus;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use App\Mail\AmountWithdrawn;
use App\Managers\PaymentManager;
use App\Models\User;
use App\Models\VendorTransaction;
use App\Models\WithdrawAccount;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\WithPagination;

class PaymentHistoryIndexController extends PaymentHistoryAbstract
{
    use ResetsPagination,
        WithPagination,
        WithBootstrapPagination;

    public string $search = '';

    /**
     * @var array<mixed>
     */
    public array $dateRange = [];

    public array $stripeUserInfo = [];

    public string $detailsSubmitted = '';

    public User $user;

    public function mount()
    {
        $this->user = User::where('id', Auth::user()->id)->with('withdrawAccount')->first();
        $paymentManager = app(PaymentManager::class);

        if ($this->user->withdrawAccount) {
            $this->stripeUserInfo = $paymentManager->getVendor($this->user->withdrawAccount->stripe_id)->toArray();
            if ($this->stripeUserInfo['details_submitted'] == false) {
                $this->detailsSubmitted = 'No';
            } else {
                $this->detailsSubmitted = 'Yes';
            }
        } else {
            $this->detailsSubmitted = 'No';
        }
    }

    public function render(): View
    {
        return $this->view('frontend.vendor.payment-history.payment-history-index-controller', function (View $view) {
            $view->with('vendorTransactions', $this->getVendorTransactions());
        });
    }

    public function getVendorTransactions(): Paginator
    {
        $query = VendorTransaction::query()
            ->where('vendor_id', Auth::user()->id)
            ->when($this->search, fn ($query) => $query->search($this->search))
            ->when(! empty($this->dateRange), fn ($query) => $query->dateFilter($this->dateRange));

        return $query
            ->latest('id')
            ->paginate(10);
    }

    public function deleteBankAccount()
    {
        try {
            $user = auth()->user();

            WithdrawAccount::whereId($user->id)->delete();

            $this->emit('alert-success', trans('vendor.account.detached'));

            $this->dispatchBrowserEvent('hidedetachmodal');

            return to_route('vendor.payment.history.index');
        } catch (\Throwable $th) {
            $this->dispatchBrowserEvent('hidedetachmodal');
            throw $th;
        }
    }

    public function withdrawAmount()
    {
        try {
            $user = Auth::user();

            if ($this->stripeUserInfo['capabilities']['card_payments'] != 'active' && $this->stripeUserInfo['capabilities']['transfers'] != 'active') {
                throw new Exception(trans('vendor.payment.withdraw.error'));
            }
            $paymentManager = app(PaymentManager::class);
            $params = new Withdraw(
                amount: number_format((float) $user->balance, 2, '.', ''),
                destination: $user->withdrawAccount->stripe_id,
            );

            $stripeResponse = $paymentManager->driver('stripe')->withdrawAmount($params);

            if (($stripeResponse->data->response->object) == 'transfer') {
                DB::beginTransaction();

                VendorTransaction::create([
                    'vendor_id' => Auth::user()->id,
                    'summary' => 'Withdraw completed',
                    'balance' => 0,
                    'status' => TransactionStatus::Pending,
                ]);
                $balance = number_format((float) $user->balance, 2, '.', '');

                Mail::send(new AmountWithdrawn($user, $balance));
                Mail::send(new AmountWithdrawn($user, $balance, true));

                $user->balance = 0;
                $user->save();
                DB::commit();

                $this->dispatchBrowserEvent('hidemodal');

                $this->emit('alert-success', trans('vendor.payment.withdraw.successful'));

                return to_route('vendor.payment.history.index');
            }

            VendorTransaction::create([
                'summary' => 'Withdraw rejected',
                'balance' => $user->balance,
                'status' => TransactionStatus::Pending,
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            $this->dispatchBrowserEvent('hidemodal');
            if ($e instanceof \Stripe\Exception\ApiErrorException) {
                return $this->emit('alert-danger', $e->getError()->message);
            }

            return $this->emit('alert-danger', $e->getMessage());
        }
    }

    public function resetFields(): void
    {
        $this->search = '';
        $this->dateRange = [];
    }
}
