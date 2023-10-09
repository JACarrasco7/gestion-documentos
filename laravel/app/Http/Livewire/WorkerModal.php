<?php

namespace App\Http\Livewire;

use App\Models\Worker;
use App\Rules\nif;
use App\Rules\phone;
use App\Rules\postal_code;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class WorkerModal extends ModalComponent
{
    public Worker $worker;
    public $entity_id = Worker::ENTITY_ID;
    public array $state = [];
    public $insert = true;
    public $document_template;

    public function mount()
    {
        try {
            // worker data
            $this->state = $this->worker->toArray();
            // Merge worker data with its contact info
            $this->state = array_merge($this->state, $this->worker->contact_info->toArray());
            // Get linked templates ids
            $this->document_template = $this->worker->templates->pluck('id');
            $this->insert = false;
        } catch (\Throwable $th) {
            $this->worker = new Worker;
        }
    }

    public function render()
    {
        return view('livewire.worker-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'nif' => ['required', new Nif, 'unique:workers,nif,' . $this->worker->id],
            'city' => 'sometimes',
            'province' => 'sometimes',
            'postal_code' => ['sometimes', new Postal_code],
            'address' => 'sometimes',
            'email' => 'sometimes|email',
            'document_template_id' => 'required|array',
            'document_template_id.*' => 'required',
            'company_id' => 'required',
            'phone_1' => ['sometimes', new Phone],
        ];
    }

    public function save()
    {
        $this->state['document_template_id'] = $this->document_template;
        $this->state['company_id'] = auth()->user()->company_id;

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();
        // Emit the event to send data to table component
        $document_template = $validatedData['document_template_id'];
        unset($validatedData['document_template_id']);

        if ($validatedData) {
            $this->emitTo('worker-table', 'saveWorker', $validatedData, $document_template, $this->worker->id);
        }
    }
}
