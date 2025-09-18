<?php

namespace Database\Factories;

use App\Models\DataKaryawan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DataKaryawan>
 */
class DataKaryawanFactory extends Factory
{
    // Nama asal model dari factory ini
    protected $model = DataKaryawan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'nomor_telepon' => fake()->phoneNumber(),
            'status_karyawan' => fake()->randomElement(['Karyawan Tetap', 'Karyawan Kontrak']),
            'keahlian' => fake()->bs(),
            'jabatan' => fake()->jobTitle(),
            'rekrutmen_id' => null,
            'user_id' => $user->id_user,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
