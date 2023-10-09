<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'name' => 'Martillo',
            'description' => 'Es un martillo',
            'company_id' => 1,
            'document_template_id' => 3
        ]);
    }
}
