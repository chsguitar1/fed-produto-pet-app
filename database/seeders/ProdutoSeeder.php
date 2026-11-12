<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;
use Database\Factories\ProdutoFactory;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lotes = Lote::query()->orderBy('numero_lote')->get();

        if ($lotes->isEmpty()) {
            throw new \LogicException('Execute LoteSeeder antes de ProdutoSeeder.');
        }

        foreach (ProdutoFactory::CATALOG as $index => $catalogItem) {
            $marca = Marca::query()
                ->where('marca', $catalogItem['marca'])
                ->firstOrFail();
            $categoria = Categoria::query()
                ->where('categoria', $catalogItem['categoria'])
                ->firstOrFail();
            $lote = $lotes[$index % $lotes->count()];

            Produto::factory()->create([
                'produto' => $catalogItem['produto'],
                'quantidade' => $catalogItem['quantidade'],
                'preco_custo' => $catalogItem['preco_custo'],
                'preco_venda' => $catalogItem['preco_venda'],
                'lote_id' => $lote->id,
                'categoria_id' => $categoria->id,
                'marca_id' => $marca->id,
            ]);
        }
    }
}
