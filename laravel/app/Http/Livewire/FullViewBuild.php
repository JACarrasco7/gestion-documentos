<?php

namespace App\Http\Livewire;

use App\Models\Build;
use App\Models\Company;
use App\Models\Worker;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class FullViewBuild extends Component
{
    public $build;
    public $filter_validation;
    public array $documentsBuild = [];
    public array $KeysDocumentsCompanyRequired = [], $documentsCompanyRequired = [];
    public array $KeysDocumentsWorkerRequired = [], $documentsWorkerRequired = [];
    public array $KeysDocumentsMachineRequired = [], $documentsMachineRequired = [];

    public function mount($id)
    {
        $this->build = Build::find($id);
    }

    public function render()
    {
        $this->getAllDocuments();
        return view('livewire.full-view-build');
    }

    public function getAllDocuments()
    {

        $entities = config('constants.ENTITY_TEMPLATE_en.name');
        $documentsEntities = [];
        foreach ($entities as $entity) {
            $model_name = Str::singular($entity);
            foreach ($this->build->$entity as $entity_model) {
                dd($entity_model->templates);
                foreach ($entity_model->templates as $template) {
                    dd($template);
                    $documentTemplateEntity = $template->document_type;

                    foreach ($documentTemplateEntity as $document) {
                        foreach ($entity_model->documents as $documentUpload) {
                            if ($document->id == $documentUpload->document_type_id) {
                                $documentsEntities[$model_name::ENTITY_ID][$entity_model->id][$template->id]['documentsUpload'][$document->id] = $documentUpload;
                            }
                        }
                        $documentsEntities[$model_name::ENTITY_ID][$entity_model->id]['documentNeeded'][$template->id][$document->id] = $document;
                    }
                    $documentsEntities[$model_name::ENTITY_ID][$entity_model->id]['data'] = $entity_model;
                }
            }
        }
        dd($documentsEntities);
        $this->documentsBuild = $documentsEntities;
    }

    public function getDocumentsWorkerRequired(Worker $worker, Build $build)
    {
        $documentsWorkerTemplate = $worker->getDocuments($build);

        foreach ($documentsWorkerTemplate as $documentWorkerTemplate) {
            if (!$documentWorkerTemplate->isEmpty()) {
                foreach ($documentWorkerTemplate as $key => $document_Required) {
                    $this->documentsWorkerRequired[$document_Required->document_type_id] = [
                        'document_validation_id' => $document_Required->document_validation_id,
                    ];
                }
            }
        }

        $this->KeysDocumentsWorkerRequired = array_keys($this->documentsWorkerRequired);
    }

    public function getDocumentsCompanyRequired(Company $company, Build $build)
    {
        $documentsCompanyTemplate = $company->getDocuments($build);
        foreach ($documentsCompanyTemplate as $documentCompanyTemplate) {
            if (!$documentCompanyTemplate->isEmpty()) {
                $last_validation = $documentCompanyTemplate[0]->validations[count($documentCompanyTemplate[0]->validations) - 1]->id;
                $this->documentsCompanyRequired[$documentCompanyTemplate[0]->document_type_id] = [
                    'document_validation_id' => $last_validation ? $last_validation : config('constants.DOCUMENT_VALIDATION_ID.Pendiente'),
                ];
            }
        }

        $this->KeysDocumentsCompanyRequired = array_keys($this->documentsCompanyRequired);
    }

    public function getDocumentsMachineRequired(Build $build)
    {
        $documentsBuildTemplate = $build->getDocuments($build);
        foreach ($documentsBuildTemplate as $documentMachineTemplate) {
            if (!$documentMachineTemplate->isEmpty()) {
                $last_validation = $documentMachineTemplate[0]->validations[count($documentMachineTemplate[0]->validations) - 1]->id;
                $this->documentsMachineRequired[$documentMachineTemplate[0]->document_type_id] = [
                    'document_validation_id' => $last_validation ? $last_validation : config('constants.DOCUMENT_VALIDATION_ID.Pendiente'),
                ];
            }
        }
        $this->KeysDocumentsMachineRequired = array_keys($this->documentsMachineRequired);
    }

    public function checkDocumentUpload($document, $documentsUpload)
    {
        foreach ($documentsUpload as $documentUpload)
            return $documentUpload->document_type_id == $document->id ? true : false;
    }

    public function checkDocumentValidate($document, $documentsUpload)
    {
        foreach ($documentsUpload as $documentUpload)
            if (($document->id == $documentUpload->document_type_id) && $documentUpload->validations) {
                $count_validations = count($documentUpload->validations) > 0 ? count($documentUpload->validations) - 1 : 0;
                $last_validation_id = $documentUpload->validations[$count_validations]->id;
                return $last_validation_id == config('constants.DOCUMENT_VALIDATION_ID.Validado') ? true : false;
            }
    }

    public function checkDocumentRefused($document, $documentsUpload)
    {
        foreach ($documentsUpload as $documentUpload)
            if (($document->id == $documentUpload->document_type_id) && $documentUpload->validations) {
                $count_validations = count($documentUpload->validations) > 0 ? count($documentUpload->validations) - 1 : 0;
                $last_validation_id = $documentUpload->validations[$count_validations]->id;
                return $last_validation_id == config('constants.DOCUMENT_VALIDATION_ID.Rechazado') ? true : false;
            }
    }

    public function checkDocumentPending($document, $documentsUpload)
    {
        foreach ($documentsUpload as $documentUpload)
            if (($document->id == $documentUpload->document_type_id) && $documentUpload->validations) {
                $count_validations = count($documentUpload->validations) > 0 ? count($documentUpload->validations) - 1 : 0;
                $last_validation_id = $documentUpload->validations[$count_validations]->id;
                return $last_validation_id == config('constants.DOCUMENT_VALIDATION_ID.Pending') ? true : false;
            }
    }
    public function checkDocumentExpired($document, $documentsUpload)
    {
        foreach ($documentsUpload as $documentUpload)
            if (($document->id == $documentUpload->document_type_id) && $documentUpload->validations) {
                $count_validations = count($documentUpload->validations) > 0 ? count($documentUpload->validations) - 1 : 0;
                $last_validation_id = $documentUpload->validations[$count_validations]->id;
                return $last_validation_id == config('constants.DOCUMENT_VALIDATION_ID.Caducado') ? true : false;
            }
    }
}
