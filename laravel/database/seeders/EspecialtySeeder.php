<?php

namespace Database\Seeders;

use App\Models\Especialty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Especialty::create([
            'name'=>'Cristalería',
        ]);
    }
}
