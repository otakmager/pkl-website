<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TMasuk>
 */
class TMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $startDate = Carbon::createFromDate(2022, 12, 25);
        $endDate = Carbon::createFromDate(2023, 6, 1);
        return [
            'name' => fake()->words(mt_rand(1,3), true),
            'slug' => fake()->unique()->slug(),
            'label_id' => mt_rand(1,3),
            'nominal' => mt_rand(10000,200000),
            'tanggal' => $this->faker->dateTimeBetween($startDate, $endDate),
        ];
    }
}
