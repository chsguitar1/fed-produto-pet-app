<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Database\Factories\CategoriaFactory;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CategoriaFactory::CATEGORIES as $category) {
            Categoria::factory()->create([
                'categoria' => $category,
                'estoque' => true,
            ]);
        }
    }
}
