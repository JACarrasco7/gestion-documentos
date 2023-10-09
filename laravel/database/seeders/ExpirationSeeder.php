<?php

namespace Database\Seeders;

use App\Models\Expiration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpirationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expiration::create([
            'name'=>'nunca'
        ]);
    }
}
