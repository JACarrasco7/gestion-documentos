<?php

namespace App\Http\Livewire;

use App\Models\DocumentTemplateCompany;
use App\Models\Especialty;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class EspecialtyModal extends ModalComponent
{
    public Especialty $especialty;
    public array $state = [];
    public $insert = true;

    public function mount()
    {
        try {
            $this->state = $this->especialty->toArray();
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->especialty = new Especialty;
        }
    }

    public function render()
    {
        return view('livewire.especialty-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'description' => 'sometimes|max:255',
        ];
    }

    public function save()
    {

        // check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {

            $this->state['description'] = null;
        }

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('especialty-table', 'saveEspecialty', $validatedData, $this->especialty->id);
        }
    }
}
