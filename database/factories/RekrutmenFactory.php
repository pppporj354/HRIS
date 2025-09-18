<?php

namespace Database\Factories;

use App\Models\Rekrutmen;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rekrutmen>
 */
class RekrutmenFactory extends Factory
{
    // Nama asal model dari factory ini
    protected $model = Rekrutmen::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->freeEmail(),
            'nomor_telepon' => fake()->phoneNumber(),
            'alamat' => fake()->address(),
            'keahlian' => fake()->bs(),
            'catatan' => fake()->sentence(),
            'status_rekrutmen' => 'Proses',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
