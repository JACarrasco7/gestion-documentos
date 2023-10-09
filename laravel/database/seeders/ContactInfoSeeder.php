<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactInfo::create([
            'province' => 'Bormujos',
            'city' => 'Sevilla',
            'postal_code' => '41930',
            'address' => 'Calle bermejales,23',
            'email' => 'nextpyme@gmail.com',
            'phone_1' => '123123123',
        ]);

        ContactInfo::create([
            'province' => 'Lepe',
            'city' => 'Huelva',
            'postal_code' => '03930',
            'address' => 'Calle junco,41',
            'email' => 'nextpyme@gmail.com',
            'phone_1' => '123123123',
        ]);

        ContactInfo::create([
            'province' => 'Algeciras',
            'city' => 'Cádiz',
            'postal_code' => '31980',
            'address' => 'Calle harina,41',
            'email' => 'nextpyme@gmail.com',
            'phone_1' => '123123123',
        ]);
    }
}
