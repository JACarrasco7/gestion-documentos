<?php

namespace App\Http\Livewire;

use App\Models\Entity;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class EntityModal extends ModalComponent
{
    public Entity $entity;
    public array $state = [];
    public $insert = true;

    /**
     * Function to mount modal according to procces
     *
     */
    public function mount()
    {
        try {
            // Get data Entity for Modify
            $this->state = $this->entity->toArray();

            // Action
            $this->insert = false;
        } catch (\Throwable $th) {
            // Initialize new Entity
            $this->entity = new Entity;
        }
    }

    /**
     * Function to render modal
     *
     */
    public function render()
    {
        return view('livewire.entity-modal');
    }

    /**
     * Function to sets the size of the modal
     *
     * @return string
     */
    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    /**
     * Function to set validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'description' => 'sometimes|max:255',
        ];
    }

    /**
     * Function to prepare data, save or modify an Entity
     * and send data to the table to save
     */
    public function save()
    {
        // Check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {
            $this->state['description'] = null;
        }

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('entity-table', 'saveEntity', $validatedData, $this->entity->id);
        }
    }
}
