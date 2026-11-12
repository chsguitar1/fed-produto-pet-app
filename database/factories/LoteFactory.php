<?php

namespace Database\Factories;

use App\Models\Lote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lote>
 */
class LoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero_lote' => fake()->unique()->numerify('LOTE-2026-####'),
        ];
    }
}
