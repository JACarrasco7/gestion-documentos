<?php

namespace App\Models;

use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expiration extends Model
{
    use HasFactory,WithActiveScope;
    protected $fillable = [
        'name',
        'validate_date',
        'status',
        'description'
    ];


    public function documents(){
        return $this->hasMany(DocumentType::class);
    }

}
