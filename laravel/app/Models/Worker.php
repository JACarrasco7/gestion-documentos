<?php

namespace App\Models;

use App\Traits\HasDocuments;
use App\Traits\UseContactInfo;
use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory, UseContactInfo, HasDocuments, WithActiveScope;

    /**
     * Path where workers' folder is located
     */
    public const DOCUMENT_PATH = "/Trabajadores/";
    public const ENTITY_ID = 3;

    protected $fillable = [
        'name',
        'nif',
        'contact_info_id',
        'company_id',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function builds()
    {
        return $this->belongsToMany(Build::class);
    }

    /**
     * Get the documents path for a given $build
     * @return string
     */
    private function getDocumentPath($build)
    {
        return date('Y') . '/' . $build->name . '/' . $this->company->name . Worker::DOCUMENT_PATH . $this->name . '/';

    }

    public function templates()
    {
        return $this->belongsToMany(DocumentTemplate::class, 'worker_document_template')->withTimestamps();

    }
}
