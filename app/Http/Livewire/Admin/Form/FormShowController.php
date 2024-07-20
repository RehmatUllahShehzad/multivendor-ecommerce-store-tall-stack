<?php

namespace App\Http\Livewire\Admin\Form;

use App\Models\Form;

class FormShowController extends FormAbstract
{
    public Form $form;

    public function render()
    {
        return $this->view('admin.form.form-show-controller');
    }
}
