<?php

namespace App\Http\Livewire;

use App\Models\DocumentTemplate;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class TemplateModal extends ModalComponent
{
    public DocumentTemplate $template;
    public array $state = [];
    public $insert = true;

    public function mount()
    {
        try {
            $this->state = $this->template->toArray();
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->template = new DocumentTemplate;
        }
    }
    public function render()
    {
        return view('livewire.template-modal');
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
            $this->emitTo('template-table', 'saveTemplate', $validatedData, $this->template->id);
        }
    }
}
