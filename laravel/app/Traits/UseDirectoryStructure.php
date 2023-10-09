<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/**
 * Trait to manage build's folder structure
 */
trait UseDirectoryStructure
{
    /**
     * Create folders structure
     */
    public function createDirectories()
    {
        $buildName = $this->name;
        $year = date('Y');

        foreach ($this->companies as $company) {
            // Company folder
            if (!$continue = Storage::disk('ftp')->exists($year . '/' . $buildName . '/' . $company->name)) {
                $continue = Storage::disk('ftp')->makeDirectory($year . '/' . $buildName . '/' . $company->name);
            }

            if (!$continue)
                return false;

            $path = $year . '/' . $buildName . '/' . $company->name;
            // Create workers,machines,build,enterprise
            Storage::disk('ftp')->makeDirectory($path . '/Empresa');
            Storage::disk('ftp')->makeDirectory($path . '/Maquinaria');
            $continue = Storage::disk('ftp')->makeDirectory($path . '/Trabajadores');

            if (!$continue)
                return false;

            $workerPath = $path . '/Trabajadores/';
            $machineryPath = $path . '/Maquinaria/';

            // Workers folders

            // Check if worker's folders are empty to delete them
            foreach (Storage::disk('ftp')->allDirectories($workerPath) as $folder) {
                if (!Storage::disk('ftp')->allFiles($folder))
                    Storage::disk('ftp')->deleteDirectory($folder);
            }

            // Make new worker's folders
            foreach ($this->workersByCompany($company->id) as $worker) {
                if (!$continue = Storage::disk('ftp')->exists($workerPath . $worker->name)) {
                    $continue = Storage::disk('ftp')->makeDirectory($workerPath . $worker->name);
                }

                if (!$continue)
                    return false;

                // Worker's template docs' folders
                foreach ($worker->templates as $template) {

                    foreach ($template->document_type as $doc_type) {

                        if (!$continue = Storage::disk('ftp')->exists($workerPath . $worker->name . '/' . $doc_type->name)) {
                            $continue = Storage::disk('ftp')->makeDirectory($workerPath . $worker->name . '/' . $doc_type->name);
                        }

                        if (!$continue)
                            return false;
                    }
                }
            }
        }
        return true;
    }
}
