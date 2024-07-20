<?php

namespace App\Http\Livewire\Admin\Form;

use App\Models\Form;
use Illuminate\Contracts\View\View;

class FormIndexController extends FormAbstract
{
    public string $search = '';

    public function render()
    {
        return $this->view('admin.form.form-index-controller', function (View $view) {
            $view->with('forms', $this->getForms());
        });
    }

    public function getForms()
    {
        $query = Form::query();

        if (strlen($this->search) > 3) {
            $query->where('first_name', 'LIKE', "%{$this->search}%");
        }

        return $query->latest()->paginate(10);
    }
}
