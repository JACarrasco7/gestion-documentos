<?php

namespace App\Http\Livewire;

use App\Models\Expiration;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class DocumentExpirationTypeModal extends ModalComponent
{
    public Expiration $expiration;
    public array $state = [];
    public $insert = true;

    public function mount()
    {
        try {
            $this->state = $this->expiration->toArray();
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->expiration = new Expiration;
        }
    }
    public function render()
    {
        return view('livewire.document-expiration-type-modal');
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
            'validate_date' => 'sometimes|boolean',
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
            $this->emitTo('document-expiration-type-table', 'saveExpiration', $validatedData, $this->expiration->id);
        }
    }
}
