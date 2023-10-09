<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Document;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class ValidationModal extends ModalComponent
{

    public Document $document;
    public Company $company;
    public $validation_id;
    public $observations;
    public $validations = [];

    protected $rules = [
        'validation_id' => 'required',
        'observations' => 'sometimes|max:255',
    ];

    public function mount()
    {

        $this->document->downloadLocally();
    }


    public function render()
    {
        $this->getValidations();
        return view('livewire.validation-modal');
    }

    /**
     * Function to sets the size of the modal
     *
     * @return string
     */
    public static function modalMaxWidth(): string
    {
        return '7xl';
    }

    public function close()
    {

        $this->document->deleteLocalFile();
        $this->closeModal();
    }

    public static function closeModalOnEscape(): bool
    {
        return false;
    }

    public static function closeModalOnClickAway(): bool
    {
        return false;
    }

    public function getValidations()
    {
        $this->validations = $this->document->validations()->orderByPivot('created_at','desc')->limit(4)->get();
    }

    public function save()
    {
        $validatedData = $this->validate();
        // Insert user_id field
        $validatedData['user_id'] = auth()->user()->id;
        // Save the validation
        $this->document->validations()->attach($this->validation_id, $validatedData);
        $this->getValidations();
        $this->emitTo('validate-documents','getCompanyDocuments');
    }
}
