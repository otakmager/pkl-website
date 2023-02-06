<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TKeluar>
 */
class TKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->words(mt_rand(1,3), true),
            'slug' => fake()->unique()->slug(),
            'label' => 'Beli Alat dan Bahan',
            'nominal' => 10000,
            'tanggal' => now(),
        ];
    }
}
