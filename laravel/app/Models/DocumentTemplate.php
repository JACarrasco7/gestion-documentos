<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'entity_id'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function document_type()
    {
        return $this->belongsToMany(DocumentType::class);
    }

    /**
     * @param int $entity_id
     * @return mixed all document_template for a given entity
     */
    public static  function byEntity(int $entity_id){
        return DocumentTemplate::query()->where('entity_id',$entity_id)->get();
    }
}
