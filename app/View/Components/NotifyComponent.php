<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NotifyComponent extends Component
{
    /**
     * An array of messages to show.
     *
     * @var array<string>
     */
    public array $messages = [];

    /**
     * Define the level of the notification.
     *
     * @var string
     */
    public $level = 'success';

    /**
     * Initialise the component.
     */
    public function __construct(string $level = 'success')
    {
        if ($message = session()->get('notify.message')) {
            $this->messages[] = $message;
        }

        $this->level = session()->get('notify.level', $level);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.notify-component');
    }
}
