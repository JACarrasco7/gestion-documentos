<?php

namespace App\Http\Livewire;

use App\Models\Machine;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class MachineModal extends ModalComponent
{
    public Machine $machine;
    public array $state = [];
    public $company;
    public $entity_id = Machine::ENTITY_ID;
    public $document_template;
    public $insert = true;

    public function mount()
    {
        try {
            $this->state = $this->machine->toArray();
            $this->company = $this->company->id;
            $this->document_template = $this->company->document_template_id;
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->machine = new Machine;
        }
    }
    public function render()
    {
        return view('livewire.machine-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'company_id' => 'required',
            'document_template_id' => 'required',
            'description' => 'sometimes|max:255',
        ];
    }

    public function save()
    {
        //Get select
        $this->state['company_id'] = $this->company;
        $this->state['document_template_id'] = $this->document_template;

        // check for prevent description field to have only whitespaces
        if (key_exists('description', $this->state) && trim($this->state['description']) == '') {

            $this->state['description'] = null;
        }
        Log::debug(print_r($this->state, true));
        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('machine-table', 'saveMachine', $validatedData, $this->machine->id);
        }
    }
}
