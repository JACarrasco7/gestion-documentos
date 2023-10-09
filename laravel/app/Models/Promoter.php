<?php

namespace App\Models;

use App\Traits\UseContactInfo;
use App\Traits\WithActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promoter extends Model
{
    use HasFactory, UseContactInfo,WithActiveScope;
    protected $fillable = [
        'name',
        'status',
        'contact_name_1',
        'contact_email_1',
        'contact_name_2',
        'contact_email_2',
        'contact_info_id'
    ];
}
