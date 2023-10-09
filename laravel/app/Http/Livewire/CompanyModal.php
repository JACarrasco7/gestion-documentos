<?php

namespace App\Http\Livewire;

use App\Models\DocumentTemplate;
use App\Models\DocumentTemplateCompany;
use App\Models\Especialty;
use App\Models\Company;
use App\Rules\nif;
use App\Rules\phone;
use App\Rules\postal_code;
use Illuminate\Support\Facades\Validator;
use LivewireUI\Modal\ModalComponent;

class CompanyModal extends ModalComponent
{
    public Company $company;

    public $entity_id = Company::ENTITY_ID;
    public array $state = [];
    public $insert = true;

    public $document_template;
    public $especialty_id;

    public function mount()
    {
        try {

            $this->state = $this->company->toArray();
            $this->state = array_merge($this->state, $this->company->contact_info->toArray());
            $this->document_template = $this->company->document_template_id;
            $this->especialty_id = $this->company->especialty_id;

            $this->insert = false;
        } catch (\Throwable $th) {
            $this->company = new Company;
        }
    }

    public function render()
    {
        return view('livewire.company-modal');
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'experience' => 'sometimes|string|max:200',
            'cif' => ['required', new Nif],
            'city' => 'required',
            'province' => 'required',
            'postal_code' => ['required', new Postal_code],
            'address' => 'required',
            'document_template_id' => 'required',
            'especialty_id' => 'required',
            'phone_1' => ['sometimes', new Phone]

        ];
    }

    public function save()
    {

        $this->state['document_template_id'] = $this->document_template;
        $this->state['especialty_id'] = $this->especialty_id;

        // Validate data inputs
        $validatedData = Validator::make($this->state, $this->rules())->validate();

        // Emit the event to send data to table component
        if ($validatedData) {
            $this->emitTo('company-table', 'saveCompany', $validatedData, $this->company->id);
        }
    }

    public function getTemplates()
    {
        return DocumentTemplate::byEntity(Company::ENTITY_ID);
    }

    public function getEspecialties()
    {
        return Especialty::all();
    }
}
