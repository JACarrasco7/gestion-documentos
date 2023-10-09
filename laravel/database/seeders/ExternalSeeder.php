<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // External
        \App\Models\User::create([
            'name' => 'Julián coord',
            'username' => 'juli',
            'email' => 'julian_externo@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('External');

        // External
        \App\Models\User::create([
            'name' => 'Samuel coord',
            'username' => 'samu',
            'email' => 'samu_externo@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('External');

        // External
        \App\Models\User::create([
            'name' => 'Ruben coord',
            'username' => 'ruben',
            'email' => 'ruben_externo@areacontruccion.com',
            'password' => bcrypt('123'),
        ])->assignRole('External');
    }
}
