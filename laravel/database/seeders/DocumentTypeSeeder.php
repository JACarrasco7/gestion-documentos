<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         *
         * NOT CHANGE CREATION ORDER
         *
         */
        DocumentType::create([
            'name'=>'dni',
            'entity_id'=>3,
            'expiration_id'=>1,
        ]);

        DocumentType::create([
            'name'=>'cif',
            'entity_id'=>1,
            'expiration_id'=>1,
        ]);

        DocumentType::create([
            'name'=>'contrato',
            'entity_id'=>1,
            'expiration_id'=>1,
        ]);

        DocumentType::create([
            'name'=>'Carnet B2',
            'entity_id'=>3,
            'expiration_id'=>1,
        ]);

        DocumentType::create([
            'name'=>'manual martillo',
            'entity_id'=>2,
            'expiration_id'=>1,
        ]);

    }
}
