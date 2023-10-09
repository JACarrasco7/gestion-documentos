<?php

namespace App\Http\Livewire;

use App\Models\Build;
use LivewireUI\Modal\ModalComponent;

class AddMachineModal extends ModalComponent
{
    public Build $build;
    public $machine_id = [];
    protected $rules = ['machine_id' => 'array'];
    public function mount()
    {
        try {
            // get build's company's machines
            $this->machine_id = $this->build->machinesByCompany(auth()->user()->company->id)->pluck('id');
        } catch (\Throwable $th) {
            $this->closeModal();
        }
    }
    public function render()
    {
        return view('livewire.add-machine-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function save()
    {
        // Validate data inputs
        $validatedData = $this->validate()['machine_id'];
        $this->emit('saved');
        // Emit the event to send data to table component
        if (isset($validatedData)) {
            $this->emitTo('build-table', 'assignMachine', $this->build, $validatedData);
        }
    }
}
