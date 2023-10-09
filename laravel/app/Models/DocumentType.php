<?php

namespace App\Models;

use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory,WithActiveScope;

    protected $fillable = [
        'name',
        'description',
        'max_docs',
        'restricts_access',
        'type',
        'entity_id',
        'status',
        'expiration_id'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function expiration()
    {
        return $this->belongsTo(Expiration::class);
    }
}
