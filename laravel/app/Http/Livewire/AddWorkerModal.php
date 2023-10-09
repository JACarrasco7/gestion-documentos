<?php

namespace App\Http\Livewire;

use App\Models\Build;
use LivewireUI\Modal\ModalComponent;

class AddWorkerModal extends ModalComponent
{
    public Build $build;
    public $worker_id = [];
    protected $rules = ['worker_id' => 'array'];
    public function mount()
    {
        try {
            // get build's company's workers
            $this->worker_id = $this->build->workersByCompany(auth()->user()->company->id)->pluck('id');
        } catch (\Throwable $th) {
            $this->closeModal();
        }
    }
    public function render()
    {
        return view('livewire.add-worker-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function save()
    {
        // Validate data inputs
        $validatedData = $this->validate()['worker_id'];
        $this->emit('saved');
        // Emit the event to send data to table component
        if (isset($validatedData)) {
            $this->emitTo('build-table', 'assignWorker', $this->build, $validatedData);
        }
    }
}
