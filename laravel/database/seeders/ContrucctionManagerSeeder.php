<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContrucctionManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Construction_manager
        \App\Models\User::create([
            'name' => 'Pepe jefe',
            'username' => 'pepito',
            'email' => 'pepe_jefe@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('Construction_manager');

        // Construction_manager
        \App\Models\User::create([
            'name' => 'Manuel jefe',
            'username' => 'manu',
            'email' => 'manu_jefe@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('Construction_manager');

        // Construction_manager
        \App\Models\User::create([
            'name' => 'Cristian jefe',
            'username' => 'cris',
            'email' => 'cris_jefe@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('Construction_manager');
    }
}
