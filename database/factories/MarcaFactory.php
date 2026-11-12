<?php

namespace Database\Factories;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Marca>
 */
class MarcaFactory extends Factory
{
    /** @var list<array{marca: string, fabricante: string}> */
    public const BRANDS = [
        ['marca' => 'NutriPet', 'fabricante' => 'Alimentos Pet Brasil'],
        ['marca' => 'MiauMix', 'fabricante' => 'Nutrição Felina Brasil'],
        ['marca' => 'PetDelícia', 'fabricante' => 'Petiscos Brasil'],
        ['marca' => 'PetBrilho', 'fabricante' => 'Higiene Pet Brasil'],
        ['marca' => 'BrincaPet', 'fabricante' => 'Brinquedos Pet Brasil'],
        ['marca' => 'PataForte', 'fabricante' => 'Acessórios Pet Brasil'],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return fake()->randomElement(self::BRANDS);
    }
}
