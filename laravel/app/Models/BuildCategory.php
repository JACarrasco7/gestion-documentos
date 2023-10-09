<?php

namespace App\Models;

use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildCategory extends Model
{
    use HasFactory,WithActiveScope;

    protected $fillable = [
        'name',
        'description',
        'status'
    ];

    public function build()
    {
        return $this->belongsTo(Build::class);
    }
}
