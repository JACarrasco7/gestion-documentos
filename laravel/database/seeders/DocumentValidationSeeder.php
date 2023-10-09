<?php

namespace Database\Seeders;

use App\Models\DocumentValidation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DocumentValidation::create([
            'name' => 'Validado'
        ]);

        DocumentValidation::create([
            'name' => 'Rechazado'
        ]);

        DocumentValidation::create([
            'name' => 'Pendiente'
        ]);

        DocumentValidation::create([
            'name' => 'Caducado'
        ]);
    }
}
