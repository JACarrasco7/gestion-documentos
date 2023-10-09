<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * !!!NOT CHANGE ORDER
     */
    public function run(): void
    {
        $arrayName = [
            'empresa',
            'maquinaria',
            'trabajador',
        ];

        foreach ($arrayName as $name) {
            Entity::create([
                'name' => $name,
                'status' => true,
            ]);
        }
    }
}
