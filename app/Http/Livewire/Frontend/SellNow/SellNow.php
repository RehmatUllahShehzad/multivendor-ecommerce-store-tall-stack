<?php

namespace App\Http\Livewire\Frontend\SellNow;

use App\Mail\SellNow as MailSellNow;
use App\Models\Form;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class SellNow extends Component
{
    public string $email = '';

    public string $first_name = '';

    public string $last_name = '';

    public string $message = '';

    public string $phone = '';

    public function mount(): void
    {
        $this->initializeInputs();
    }

    public function render(): View
    {
        return view('frontend.sell-now.sell-now');
    }

    public function submit(): void
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
        $data = $this->validate([
            'email' => 'required|email:filter,rfc,dns',
            'first_name' => 'required|max:30',
            'last_name' => 'required|max:30',
            'message' => 'required|max:700',
            'phone' => 'required|min:11|regex:/^1(?!0{10})[0-9]{10}$/',
        ]);

        Form::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'type' => Form::TYPE_SELL_NOW,
            'extra_data' => [
                'message' => $this->message,
                'phone' => $this->phone,
            ],
        ]);

        try {
            Mail::send(new MailSellNow($data));
            $this->emit('alert-success', 'Your Form Submitted Successfully.');
            $this->initializeInputs();
        } catch (Exception $exception) {
            $this->emit('alert-danger', 'Error'.$exception->getMessage());
        }
    }

    public function initializeInputs(): void
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->message = '';
        $this->phone = '';
    }
}
