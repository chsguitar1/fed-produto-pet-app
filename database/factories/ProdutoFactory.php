<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * @var list<array{
     *     produto: string,
     *     categoria: string,
     *     marca: string,
     *     fabricante: string,
     *     quantidade: int,
     *     preco_custo: float,
     *     preco_venda: float
     * }>
     */
    public const CATALOG = [
        [
            'produto' => 'Ração seca para cães adultos sabor frango e arroz 10 kg',
            'categoria' => 'Rações',
            'marca' => 'NutriPet',
            'fabricante' => 'Alimentos Pet Brasil',
            'quantidade' => 24,
            'preco_custo' => 89.90,
            'preco_venda' => 119.90,
        ],
        [
            'produto' => 'Ração para gatos castrados sabor salmão 3 kg',
            'categoria' => 'Rações',
            'marca' => 'MiauMix',
            'fabricante' => 'Nutrição Felina Brasil',
            'quantidade' => 18,
            'preco_custo' => 59.90,
            'preco_venda' => 79.90,
        ],
        [
            'produto' => 'Ração úmida para gatos sabor frango 85 g',
            'categoria' => 'Rações',
            'marca' => 'MiauMix',
            'fabricante' => 'Nutrição Felina Brasil',
            'quantidade' => 60,
            'preco_custo' => 2.50,
            'preco_venda' => 4.50,
        ],
        [
            'produto' => 'Ração para filhotes de cães sabor carne 3 kg',
            'categoria' => 'Rações',
            'marca' => 'NutriPet',
            'fabricante' => 'Alimentos Pet Brasil',
            'quantidade' => 22,
            'preco_custo' => 34.90,
            'preco_venda' => 49.90,
        ],
        [
            'produto' => 'Petisco dental para cães 120 g',
            'categoria' => 'Petiscos',
            'marca' => 'PetDelícia',
            'fabricante' => 'Petiscos Brasil',
            'quantidade' => 30,
            'preco_custo' => 15.90,
            'preco_venda' => 23.90,
        ],
        [
            'produto' => 'Biscoito para cães sabor carne 300 g',
            'categoria' => 'Petiscos',
            'marca' => 'PetDelícia',
            'fabricante' => 'Petiscos Brasil',
            'quantidade' => 25,
            'preco_custo' => 18.90,
            'preco_venda' => 27.90,
        ],
        [
            'produto' => 'Petisco cremoso para gatos sabor atum 4 unidades',
            'categoria' => 'Petiscos',
            'marca' => 'MiauMix',
            'fabricante' => 'Nutrição Felina Brasil',
            'quantidade' => 36,
            'preco_custo' => 8.90,
            'preco_venda' => 13.90,
        ],
        [
            'produto' => 'Shampoo neutro para cães 500 ml',
            'categoria' => 'Higiene',
            'marca' => 'PetBrilho',
            'fabricante' => 'Higiene Pet Brasil',
            'quantidade' => 20,
            'preco_custo' => 19.90,
            'preco_venda' => 29.90,
        ],
        [
            'produto' => 'Areia higiênica para gatos 4 kg',
            'categoria' => 'Higiene',
            'marca' => 'PetBrilho',
            'fabricante' => 'Higiene Pet Brasil',
            'quantidade' => 28,
            'preco_custo' => 11.90,
            'preco_venda' => 18.90,
        ],
        [
            'produto' => 'Tapete higiênico para cães 30 unidades',
            'categoria' => 'Higiene',
            'marca' => 'PetBrilho',
            'fabricante' => 'Higiene Pet Brasil',
            'quantidade' => 16,
            'preco_custo' => 39.90,
            'preco_venda' => 54.90,
        ],
        [
            'produto' => 'Bola de borracha resistente para cães',
            'categoria' => 'Brinquedos',
            'marca' => 'BrincaPet',
            'fabricante' => 'Brinquedos Pet Brasil',
            'quantidade' => 20,
            'preco_custo' => 12.90,
            'preco_venda' => 21.90,
        ],
        [
            'produto' => 'Arranhador de papelão para gatos',
            'categoria' => 'Brinquedos',
            'marca' => 'BrincaPet',
            'fabricante' => 'Brinquedos Pet Brasil',
            'quantidade' => 12,
            'preco_custo' => 29.90,
            'preco_venda' => 44.90,
        ],
        [
            'produto' => 'Coleira ajustável para cães porte médio',
            'categoria' => 'Acessórios',
            'marca' => 'PataForte',
            'fabricante' => 'Acessórios Pet Brasil',
            'quantidade' => 18,
            'preco_custo' => 16.90,
            'preco_venda' => 26.90,
        ],
        [
            'produto' => 'Guia de nylon para cães 1,5 m',
            'categoria' => 'Acessórios',
            'marca' => 'PataForte',
            'fabricante' => 'Acessórios Pet Brasil',
            'quantidade' => 15,
            'preco_custo' => 22.90,
            'preco_venda' => 34.90,
        ],
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $catalogItem = fake()->randomElement(self::CATALOG);

        return [
            'produto' => $catalogItem['produto'],
            'quantidade' => fake()->numberBetween(1, 60),
            'preco_custo' => $catalogItem['preco_custo'],
            'preco_venda' => $catalogItem['preco_venda'],
            'lote_id' => Lote::factory(),
            'categoria_id' => Categoria::factory()->state([
                'categoria' => $catalogItem['categoria'],
                'estoque' => true,
            ]),
            'marca_id' => Marca::factory()->state([
                'marca' => $catalogItem['marca'],
                'fabricante' => $catalogItem['fabricante'],
            ]),
        ];
    }

    public function withoutLote(): static
    {
        return $this->state(fn (array $attributes) => [
            'lote_id' => null,
        ]);
    }
}
