<?php

namespace App\Models;

use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory, WithActiveScope;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
