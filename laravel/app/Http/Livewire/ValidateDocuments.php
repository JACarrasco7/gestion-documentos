<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use WireUi\Traits\Actions;

class ValidateDocuments extends Component
{
    use Actions;

    /**
     * @var int $build_id
     * Build selected
     */
    public $build_id;

    /**
     * @var array $companies_id
     * Companies selected
     */
    public $companies_id = array();

    /**
     * Companies model collection
     */
    public $companies = array();

    /**
     * All needed document from a company and its workers and machines
     */
    public $neededDocuments = array();

    protected $listeners = [
        'getCompanyDocuments'
    ];

    public function render()
    {
        if ($this->companies_id)
            $this->getCompanyDocuments();
        return view('livewire.validate-documents');
    }


    public function updatedCompaniesId()
    {
        $this->companies = Company::whereIn('id', $this->companies_id)->get();

        $this->emit('createAccordion', $this->companies->count());

        $this->getCompanyDocuments();
    }

    // Reset $companies_id when $build_id is updated
    public function updatedBuildId()
    {
        $this->companies_id = array();
    }

    public function getCompanyDocuments()
    {

        // Reset array
        $this->neededDocuments = [];

        // Get all companies' uploaded documents
        foreach ($this->companies_id as $company_id) {
            $company = Company::find($company_id);

            // $this->neededDocuments[$company_id] = $company->documents()->where('entity_id', Company::ENTITY_ID)->get();
            $this->neededDocuments[$company_id] = $company->getAllUploadedDocuments($this->build_id);
            /*documents array data structure
            [company_id]=>[
                [entity_company]=>
                    [owner model 1]=>
                        [document model 1]
                        [document model 2]
                        .
                        .
                        .
                    [owner model 2]=>
                    .
                    .
                    .

                [entity_worker]=>
                    [owner  model 1]=>
                        [document model 1]
                        [document model 2]
                        .
                        .
                        .
                    [owner model 2]=>
                    .
                    .
                    .
                [entity_machine]=>
                    [owner model 1]=>
                        [document model 1]
                        [document model 2]
                        .
                        .
                        .
                    [owner model 2]=>
                    .
                    .
                    .
            ]
            */
        }
    }
}
