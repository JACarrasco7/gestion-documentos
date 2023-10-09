<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedDocuments extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status_id',
        'validation_date',
        'build_company_id'
    ];
}
