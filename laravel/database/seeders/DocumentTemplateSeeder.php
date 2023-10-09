<?php

namespace Database\Seeders;

use App\Models\DocumentTemplate;
use Illuminate\Database\Seeder;

class DocumentTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $template = DocumentTemplate::create([
            'name' => 'plantilla_empresa',
            'entity_id' => 1,
        ]);

        $template->document_type()->sync([2]);

        $template = DocumentTemplate::create([
            'name' => 'plantilla_trabajador',
            'entity_id' => 3,
        ]);

        $template->document_type()->sync([1, 4]);

        $template = DocumentTemplate::create([
            'name' => 'plantilla_martillo',
            'entity_id' => 2
        ]);

        $template->document_type()->sync([5]);
    }
}
