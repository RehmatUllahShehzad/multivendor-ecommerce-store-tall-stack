<?php

namespace App\Http\Livewire\Frontend\Cart\Checkout;

use App\View\Components\Frontend\Layouts\CheckoutLayout;
use Closure;
use Illuminate\View\View;
use Livewire\Component;

class CheckoutAbstract extends Component
{
    /**
     * The step
     *
     * @var int
     */
    public $currentStep;

    /**
     * The shipping price
     *
     * @var float
     */
    public $shippingPrice = null;

    /**
     * The checkout steps.
     *
     * @var array
     */
    public array $steps = [
        'shipping_address' => 0,
        'billing_address' => 1,
        'payment' => 2,
    ];

    public function view(string $view, Closure $closure = null): View
    {
        return tap(view($view), $closure)
            ->layout(CheckoutLayout::class, [
                'title' => '',
                'description' => '',
            ]);
    }
}
