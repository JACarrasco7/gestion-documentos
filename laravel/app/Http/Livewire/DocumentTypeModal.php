<?php

namespace App\Http\Livewire;

use App\Models\DocumentType;
use App\Models\Entity;
use App\Models\Expiration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class DocumentTypeModal extends ModalComponent
{
    public DocumentType $documentType;
    public array $state = [];
    public $entity, $expiration, $type;
    public $insert = true;

    public function mount()
    {
        // Initialize checkbox
        $this->state['restricts_access'] = true;
        try {
            $this->state = $this->toArray();

            // Selects
            $this->entity = $this->entity_id;
            $this->expiration = $this->expiration_id;
            $this->type = $this->type;

            // Action
            $this->insert = false;
        } catch (\Throwable $th) {
            $this = new DocumentType;
        }
    }

    public function render()
    {
        return view('livewire.document-type-modal');
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
            'max_docs' => 'required|integer|min:0',
            'restricts_access' => 'boolean',
            'type' => 'required',
            'entity_id' => 'required',
            'expiration_id' => 'required'

        ];
    }

    public function save()
    {

        // Get selects value
        $this->state['entity_id'] = $this->entity;
        $this->state['expiration_id'] = $this->expiration;
        $this->state['type'] = $this->type;

        // check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {
            $this->state['description'] = null;
        }

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();
        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('document-type-table', 'saveDocumentType', $validatedData, $this->id);
        }
    }

    public function getEntities()
    {
        return Entity::all();
    }

    public function getExpirations()
    {
        return Expiration::all();
    }
}