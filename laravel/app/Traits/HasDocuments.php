<?php

namespace App\Traits;

use App\Models\Build;
use App\Models\Company;
use App\Models\Document;
use App\Models\DocumentTemplate;
use App\Models\DocumentType;
use App\Models\Worker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Utils for menage entity's documents
 */
trait HasDocuments
{
    public function documents()
    {
        return $this->hasMany(Document::class, 'owner_id', 'id');
    }

    public function documentsByBuildAndEntity($build_id, $entity_id,$owner_id)
    {
        return $this->documents()->where('build_id', $build_id)->where('owner_id', $owner_id)->where('entity_id', $entity_id)->get();
    }

    public function documentByBuildAndDocType($build_id, $doc_type_id)
    {
        return $this->documents()->where('build_id', $build_id)->where('document_type_id', $doc_type_id)->where('owner_id', $this->id)->where('entity_id', self::ENTITY_ID);
    }

    public function document()
    {
        return $this->documents()->first();
    }

    /**
     * Function to upload documents to ftp server
     * @param array $files
     * File to upload
     *  array data structure: 'doc_type_name' => file
     *
     * @param Build $build
     * Build to upload documents
     */
    public function uploadDocuments($files, Build $build): bool
    {
        foreach ($files as $key => $files) {

            // Get the doc_type model
            $doc_type = DocumentType::find($key);

            // Get destination path
            $path = $this->getDocumentPath($build) . $doc_type->name;

            // Get all uploaded files for a doc_type
            foreach ($files as $key => $file) {

                $fileName = $file->getClientOriginalName();

                // Delete de content of the folder
                if ($filesToDelete = Storage::disk('ftp')->allFiles($path)) {

                    $documents = $this->documentByBuildAndDocType($build->id, $doc_type->id)->get();

                    if ($doc_type->max_docs <= count($documents)) {
                        if (count($filesToDelete) > 0 && Storage::disk('ftp')->delete($filesToDelete[count($filesToDelete) - 1])) {
                            // Delete de document model if files has been deleted
                            $document = $this->documentByBuildAndDocType($build->id, $doc_type->id)->orderBy('id', 'asc')->first();

                            if ($document)
                                $document->delete();
                        }
                    }
                }
                // Upload file
                $success = $file->storeAs($path, $fileName, ['disk' => 'ftp']);
                if (!$success)
                    return false;

                // Save in database
                Document::create(
                    [
                        'name' => $fileName,
                        'path' => $path,
                        'document_type_id' => $doc_type->id,
                        'entity_id' => self::ENTITY_ID,
                        'build_id' => $build->id,
                        'owner_id' => $this->id,
                        'document_validation_id' => config('constants.DOCUMENT_VALIDATION_ID.Pendiente')
                    ]
                );
            }
        }
        return true;
    }

    /**
     * @return array all uploaded documents for $build by a given $company
     */
    public function getDocuments(Build $build)
    {
        $result = [];

        foreach ($this->templates()->get() as $key => $template) {

            foreach ($template->document_type as $doc_type) {

                // Get file in doc_type folder
                $file = $this->documentByBuildAndDocType($build->id, $doc_type->id)->get();
                if ($file)
                    if (!isset($result[$doc_type->id]))
                        $result[$doc_type->id] = $file;
                    else
                        array_push($result[$doc_type->id], $file);
            }
        }
        return $result;
    }
}
