<?php

namespace Database\Seeders;

use App\Models\Rekrutmen;
use Illuminate\Database\Seeder;

class RekrutmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rekrutmen::factory()->count(5)->create();
    }
}
