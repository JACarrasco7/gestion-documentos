<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialty extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
