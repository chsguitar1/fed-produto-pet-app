<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(LazilyRefreshDatabase::class);

it('lists products with their category, brand, batch, and prices', function () {
    $now = now();
    $categoriaId = DB::table('categorias')->insertGetId([
        'categoria' => 'Alimentação',
        'estoque' => true,
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    $marcaId = DB::table('marcas')->insertGetId([
        'marca' => 'Patas & Cia',
        'fabricante' => 'Fabricante Pet',
        'created_at' => $now,
        'updated_at' => $now,
    ]);
    $loteId = DB::table('lotes')->insertGetId([
        'numero_lote' => 'LT-2026-001',
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    DB::table('produtos')->insert([
        'produto' => 'Ração para cães adultos',
        'quantidade' => 12,
        'preco_custo' => 35.50,
        'preco_venda' => 49.90,
        'lote_id' => $loteId,
        'categoria_id' => $categoriaId,
        'marca_id' => $marcaId,
        'created_at' => $now,
        'updated_at' => $now,
    ]);

    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Ração para cães adultos')
        ->assertSee('Alimentação')
        ->assertSee('Patas &amp; Cia', false)
        ->assertSee('LT-2026-001')
        ->assertSee('R$ 35,50')
        ->assertSee('R$ 49,90')
        ->assertSee('12');
});

it('shows a helpful message when there are no products', function () {
    $response = $this->get(route('home'));

    $response->assertOk()
        ->assertSee('Nenhum produto cadastrado.')
        ->assertSee('Cadastrar primeiro produto');
});
