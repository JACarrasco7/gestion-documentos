<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        // Admin
        \App\Models\User::create([
            'name' => 'Administrator',
            'username' => 'adminArea',
            'email' => 'admin@areacontruccion.com',
            'password' => bcrypt('admin')
        ])->assignRole('Administrator');

        $this->call([
            ExternalSeeder::class,
            ContrucctionManagerSeeder::class,
            DocumentValidationSeeder::class,
            BuildCategorySeeder::class,
            EspecialtySeeder::class,
            EntitySeeder::class,
            ExpirationSeeder::class,
            DocumentTypeSeeder::class,
            DocumentTemplateSeeder::class,
            ContactInfoSeeder::class,
            CompanySeeder::class,
            PromoterSeeder::class,
            BuildSeeder::class,
            WorkerSeeder::class,
            MachineSeeder::class,
        ]);

        // Company
        \App\Models\User::create([
            'name' => 'Paco',
            'username' => 'paco',
            'email' => 'paco@areacontruccion.com',
            'password' => bcrypt('paco'),
            'company_id' => 1
        ])->assignRole('Company');
    }
}
