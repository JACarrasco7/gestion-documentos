<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name' => 'Cristaleria Paco',
            'cif' => '5335442T',
            'experience' => '3',
            'especialty_id' => '1',
            'document_template_id' => 1,
            'contact_info_id' => '1',
        ]);
    }
}
