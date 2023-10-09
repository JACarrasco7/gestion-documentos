<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DocumentValidation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function validations(){
        return $this->belongsToMany(Document::class,'document_document_validations','validation_id','document_id');
    }

    /**
     * @return Attribute
     * Formated validated_at date
     */
    public function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn(string|null $date) => $date ? Carbon::create($date)->format('d-m-Y H:i') : null
        );
    }
}
