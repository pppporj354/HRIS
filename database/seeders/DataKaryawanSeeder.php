<?php

namespace Database\Seeders;

use App\Models\DataKaryawan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataKaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataKaryawan::factory()->count(10)->create();
    }
}
