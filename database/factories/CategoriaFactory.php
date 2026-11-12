<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{
    /** @var list<string> */
    public const CATEGORIES = [
        'Rações',
        'Petiscos',
        'Higiene',
        'Brinquedos',
        'Acessórios',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'categoria' => fake()->randomElement(self::CATEGORIES),
            'estoque' => true,
        ];
    }
}
