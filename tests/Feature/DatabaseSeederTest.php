<?php

use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;
use App\Models\User;
use Database\Factories\CategoriaFactory;
use Database\Factories\MarcaFactory;
use Database\Factories\ProdutoFactory;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('seeds users and catalog entries with valid product relationships', function () {
    $this->seed(DatabaseSeeder::class);

    $products = Produto::query()
        ->with(['marca', 'categoria', 'lote'])
        ->get()
        ->keyBy('produto');

    expect(User::query()->exists())->toBeTrue()
        ->and(Marca::query()->exists())->toBeTrue()
        ->and(Categoria::query()->exists())->toBeTrue()
        ->and(Lote::query()->exists())->toBeTrue();

    $this->assertDatabaseCount('marcas', count(MarcaFactory::BRANDS));
    $this->assertDatabaseCount('categorias', count(CategoriaFactory::CATEGORIES));
    $this->assertDatabaseCount('produtos', count(ProdutoFactory::CATALOG));

    foreach (ProdutoFactory::CATALOG as $catalogItem) {
        $product = $products->get($catalogItem['produto']);

        expect($product)->toBeInstanceOf(Produto::class)
            ->and($product->marca->marca)->toBe($catalogItem['marca'])
            ->and($product->categoria->categoria)->toBe($catalogItem['categoria'])
            ->and((float) $product->preco_venda)->toBeGreaterThan((float) $product->preco_custo);
    }
});

it('creates a coherent catalog product and supports products without a lot', function () {
    $product = Produto::factory()->create();
    $productWithoutLot = Produto::factory()->withoutLote()->create();
    $catalogItem = collect(ProdutoFactory::CATALOG)->firstWhere('produto', $product->produto);

    expect($catalogItem)->not->toBeNull()
        ->and($product->marca)->toBeInstanceOf(Marca::class)
        ->and($product->categoria)->toBeInstanceOf(Categoria::class)
        ->and($product->lote)->toBeInstanceOf(Lote::class)
        ->and($product->marca->marca)->toBe($catalogItem['marca'])
        ->and($product->categoria->categoria)->toBe($catalogItem['categoria'])
        ->and((float) $product->preco_venda)->toBeGreaterThan((float) $product->preco_custo)
        ->and($productWithoutLot->lote_id)->toBeNull();
});
