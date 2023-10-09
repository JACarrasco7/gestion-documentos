<?php

namespace Database\Seeders;

use App\Models\Build;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $build = Build::create([
            'name' => 'reformas Aldi',
            'start_date' => '2023-04-05',
            'description' => 'Reformas en el aldi de mairena',
            'category_id' => 2,
            'promoter_id' => 1,
            'contact_info_id' => 1,
        ]);

        $build->companies()->sync([1]);
        $build->externals()->sync([2]);
        $build->construction_managers()->sync([6]);
    }
}
