<?php

namespace App\Http\Livewire\Frontend\Vendor\Review;

use App\Http\Livewire\Frontend\VendorAbstract;
use App\Http\Livewire\Traits\ResetsPagination;
use App\Http\Livewire\Traits\WithBootstrapPagination;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class ReviewIndexController extends VendorAbstract
{
    use WithPagination, ResetsPagination, WithBootstrapPagination;

    public string $sortBy = '';

    /**
     * @var array<string>
     */
    protected $queryString = ['sortBy'];

    public function render(): View
    {
        return $this->view('frontend.vendor.review.review-index-controller', function (View $view) {
            $view->with(['reviews' => $this->reviews()]);
        });
    }

    public function reviews(): Paginator
    {

        /** @var App/Models/User */
        $user = Auth::user();

        $orderBy = [
            'oldest' => 'ASC',
            'newest' => 'DESC',
        ];

        return $user->reviews()
            ->with('product:id,title', 'product.media', 'user:id,first_name,last_name,username')
            ->when($this->sortBy, fn ($q) => $q->orderBy('id', $orderBy[$this->sortBy]))
            ->paginate(10);
    }
}
