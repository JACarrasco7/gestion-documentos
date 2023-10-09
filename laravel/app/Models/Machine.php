<?php

namespace App\Models;

use App\Traits\HasDocuments;
use App\Traits\UseDirectoryStructure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory, UseDirectoryStructure, HasDocuments;

    /**
     * Path where Machine's folder is located
     */
    public const DOCUMENT_PATH = "/Maquinas/";
    public const ENTITY_ID = 2;

    protected $fillable = [
        'name',
        'description',
        'status',
        'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function builds()
    {
        return $this->belongsToMany(Build::class);
    }

    public function templates()
    {
        return $this->belongsTo(DocumentTemplate::class, 'document_template_id');
    }
}
