<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    use HasFactory;
    protected $table = 'contact_info';

    protected $fillable = [
        'email',
        'phone_1',
        'phone_2',
        'province',
        'city',
        'postal_code',
        'address'
    ];

    public function promoter()
    {
        return $this->hasOne(Promoter::class);
    }

    public function build()
    {
        return $this->hasOne(Build::class);
    }

    public function worker()
    {
        return $this->hasOne(Worker::class);
    }
}
