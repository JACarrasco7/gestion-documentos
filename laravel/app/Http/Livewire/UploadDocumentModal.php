<?php

namespace App\Http\Livewire;

use App\Models\Build;
use App\Models\Document;
use App\Models\Entity;
use App\Models\Machine;
use App\Models\Company;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;
use WireUi\Traits\Actions;

class UploadDocumentModal extends ModalComponent
{
    use WithFileUploads, Actions;

    public Build $build;
    public Company $company;

    /**
     * @var array $entities
     * Entities that have a folder inside company's folder
     *
     * 0=>'Companies',
     * 1=>'Machines',
     * 2=>'Workers',
     * 3=>'Build'
     */
    public $entities = [];

    /**
     * @var array $rules
     * Validation rules
     */
    protected $rules = [
        'state.*.*.*' => 'file|mimes:jpg,pdf|max:102400',
        'state' => 'required'
    ];

    /**
     * @var array $messages
     * Custom validation messages
     */
    protected $messages = [
        'state.*.*.*.mimes' => 'El archivo debe ser jpg o pdf',
        'state.*.*.*.max' => 'El archivo debe pesar un máximo de 100MB',
        'state.required' => 'Seleccione algún archivo',
    ];

    public $state = [];
    /**
     * @var string $tab
     * Current tab
     */
    public $tab;

    /**
     * @var Collection<Worker> $workers
     * Companies' workers assigned to this build
     */
    public $workers;

    public $old_files;

    /**
     * @var collection
     * To save workers/build/company/machines
     */
    public $entityModels;

    public function mount()
    {
        try {
            // Get current suspplier
            $this->company = auth()->user()->company;

            // get entities that have folders
            $this->entities = config('constants.ENTITY_TEMPLATE_' . app()->getLocale())['name'];

            $this->tab = $this->entities[0];

            // Get workers
            $this->workers = $this->build->workersByCompany($this->company->id);
        } catch (\Throwable $th) {
            $this->closeModal();
        }
    }

    public function render()
    {
        // Get uploaded documentation
        $this->getDocumentation();
        return view('livewire.upload-document-modal');
    }

    public static function modalMaxWidth(): string
    {
        return '6xl';
    }

    public function save()
    {
        // Validate data inputs
        $validatedData = $this->validate();
        // Upload documents
        foreach ($validatedData['state'] as $key => $file) {

            // Get the name of the owner entity to get folder structure
            switch ($this->tab) {
                case $this->entities[0]:
                    $success = $this->company->uploadDocuments($file, $this->build);
                    break;

                case $this->entities[1]:
                    # code...
                    break;
                    // Workers
                case $this->entities[2]:
                    // Get worker
                    $worker = Worker::find($key);
                    $success = $worker->uploadDocuments($file, $this->build);
                    break;
                default:
                    return;
            }
        }

        $this->state = [];

        if ($success) {

            $this->showNotification(
                [
                    'description' => __('File uploaded.'),
                    'icon' => 'success',
                ]
            );
        }
    }

    public function updatedState($value)
    {
        $this->validate();
    }

    public function setTab($tab)
    {
        // Reset estate
        $this->state = [];
        $this->old_files = [];
        $this->resetValidation();

        // Chanche current tab
        $this->tab = $tab;
    }


    /*
     * Function to get already updated files for each entity
     */
    private function getDocumentation()
    {
        switch ($this->tab) {
            case config('constants.ENTITY_TEMPLATE_es.name.0'):
                $this->entityModels = [$this->company];
                // Get document from "Empresa" folder
                $this->old_files[$this->company->id] = $this->company->getDocuments($this->build);
                break;
            case config('constants.ENTITY_TEMPLATE_es.name.1'):
                // TODO Make machinery crud and relations
                $this->entityModels = [];
                break;
            case config('constants.ENTITY_TEMPLATE_es.name.2'):
                $this->entityModels = $this->workers;
                // Get document from "Trabajadores" folder
                foreach ($this->workers as $worker) {
                    $this->old_files[$worker->id] = $worker->getDocuments($this->build);
                }
                break;

        }
    }

    public function downloadDocument(Document $document)
    {


        // Get response to download the file
        $result = $document->download();

        // Download it
        if ($result) {

            return $result;
        }
        // Show error
        $this->notification(
            [
                'description' => __('File uploaded.'),
                'icon' => 'success',
                'timeout' => 2500,
            ]
        );
        $this->showNotification(['description' => __('An error occurred while downloading the file.'), 'icon' => 'error']);
    }

    private function showNotification($options)
    {
        $this->notification(array_merge($options, ['timeout' => 2500]));
    }
}
