<?php

namespace Database\Seeders;

use App\Models\BuildCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayBuildCategory = ['Industrial', 'Retail', 'Hoteles', 'Edificios singulares', 'Residencial', 'Energia'];

        foreach ($arrayBuildCategory as $value) {
            BuildCategory::create([
                'name' => $value,
            ]);
        }
    }
}
