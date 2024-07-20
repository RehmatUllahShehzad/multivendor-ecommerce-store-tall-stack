<?php

namespace App\View\Components\Admin\Components\Input;

use Illuminate\View\Component;

class Group extends Component
{
    /**
     * The label for the group.
     *
     * @var string
     */
    public $label;

    /**
     * Specify what input this label is bound to.
     *
     * @var string
     */
    public $for;

    /**
     * The error for this input group.
     *
     * @var string
     */
    public $error;

    /**
     * An array of validation errors.
     *
     * @var array<mixed>
     */
    public $errors = [];

    /**
     * Any instructions which should be rendered.
     *
     * @var string
     */
    public $instructions;

    /**
     * Whether this input group is required.
     *
     * @var bool
     */
    public bool $required = false;

    /**
     * Create the component instance.
     *
     * @param  string  $label
     * @param  string  $for
     * @param  string  $error
     * @param  bool  $required
     * @param  string  $instructions
     * @param  array<mixed>  $errors
     */
    public function __construct($label, $for, $error = null, $instructions = null, $required = false, $errors = [])
    {
        $this->label = $label;
        $this->for = $for;
        $this->error = $error;
        $this->instructions = $instructions;
        $this->required = $required;
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('admin.components.input.group');
    }
}
