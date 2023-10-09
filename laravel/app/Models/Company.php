<?php

namespace App\Models;

use App\Traits\HasDocuments;
use App\Traits\UseContactInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, UseContactInfo, HasDocuments;

    /**
     * Path where Company's folder is located
     */
    public const DOCUMENT_PATH = "/Empresa/";
    public const ENTITY_ID = 1;

    protected $fillable = [
        'name',
        'cif',
        'experience',
        'especialty_id',
        'document_template_id',
        'contact_info_id'
    ];

    public function especialty()
    {
        return $this->belongsTo(Especialty::class);
    }

    public function machines()
    {
        return $this->belongsTo(Machine::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function builds()
    {
        return $this->belongsToMany(Build::class);
    }

    public function workers()
    {
        return $this->hasMany(Worker::class);
    }


    /**
     * Get all documents uploaded from the company, its workers and machines
     * @param int $build_id
     * The target build to search documents
     * @return array
     * An array with documents
     */
    public function getAllUploadedDocuments(int $build_id)
    {
        // Get build
        $build = Build::find($build_id);

        // Get company's workers that are linked to $build
        $workers = $build->workers()->where('workers.company_id', $this->id)->get();

        // Final array
        $result = [];

        $result[self::ENTITY_ID] = [];
        // Get company documents
        array_push($result[self::ENTITY_ID], $this->documentsByBuildAndEntity($build_id, self::ENTITY_ID, $this->id));

        $result[Worker::ENTITY_ID] = [];
        // Get company's workers documents
        foreach ($workers as $worker) {
            array_push($result[Worker::ENTITY_ID], $this->documentsByBuildAndEntity($build_id, Worker::ENTITY_ID, $worker->id));
        }

        // Get company's workers documents
        // TODO
        // foreach ($this->machines as $machine) {
        //     $result[Machine::ENTITY_ID] = $this->documentByBuildAndEntity($build_id, Machine::ENTITY_ID, $machine->id);
        // }

        return $result;
    }

    /**
     * Get the documents path for a given $build
     * @return string
     */
    private function getDocumentPath($build)
    {
        return date('Y') . '/' . $build->name . '/' . $this->name . Company::DOCUMENT_PATH;
    }

    public function templates()
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }
}
