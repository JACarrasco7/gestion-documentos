<?php

namespace App\Http\Livewire;

use App\Models\Build;
use App\Models\Company;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class AddCompanyModal extends ModalComponent
{
    public Build $build;
    public $company_id = [];
    protected $rules = ['company_id' => 'array'];
    public function mount()
    {
        try {
            // get build's companies
            $this->company_id = $this->build->companies->map(fn ($company) => $company->id);
        } catch (\Throwable $th) {
            $this->closeModal();
        }
    }
    public function render()
    {
        return view('livewire.add-company-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'md';
    }

    public function save()
    {
        // Validate data inputs
        $validatedData = $this->validate()['company_id'];
        $this->emit('saved');

        // Emit the event to send data to table component
        if (isset($validatedData)) {
            $this->emitTo('build-table', 'assignCompany', $validatedData, $this->build);
        }
    }

    public function getCompanies()
    {
        return Company::all();
    }
}
