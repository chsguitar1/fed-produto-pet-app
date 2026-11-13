<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(LazilyRefreshDatabase::class);

it('creates categories with or without stock control', function () {
    $this->post(route('categorias.store'), [
        'categoria' => 'Alimentação',
        'estoque' => '1',
    ])->assertRedirect(route('categorias.index'))
        ->assertSessionHas('success', 'Categoria cadastrada com sucesso!');

    $this->post(route('categorias.store'), [
        'categoria' => 'Serviços',
        'estoque' => '0',
    ])->assertRedirect(route('categorias.index'));

    $this->assertDatabaseHas('categorias', [
        'categoria' => 'Alimentação',
        'estoque' => 1,
    ]);

    $this->assertDatabaseHas('categorias', [
        'categoria' => 'Serviços',
        'estoque' => 0,
    ]);
});

it('returns a validation error when a category name is missing', function () {
    $response = $this->from(route('categorias.index'))
        ->post(route('categorias.store'), ['categoria' => '']);

    $response->assertRedirect(route('categorias.index'))
        ->assertSessionHasErrors(['categoria']);

    $this->assertDatabaseCount('categorias', 0);
});

it('requires a stock control choice when creating a category', function () {
    $response = $this->from(route('categorias.index'))
        ->post(route('categorias.store'), ['categoria' => 'Alimentação']);

    $response->assertRedirect(route('categorias.index'))
        ->assertSessionHasErrors(['estoque']);

    $this->assertDatabaseCount('categorias', 0);
});

it('creates a brand and its manufacturer', function () {
    $response = $this->post(route('marcas.store'), [
        'marca' => 'Patas & Cia',
        'fabricante' => 'Fabricante Pet',
    ]);

    $response->assertRedirect(route('marcas.index'))
        ->assertSessionHas('success', 'Marca cadastrada com sucesso!');

    $this->assertDatabaseHas('marcas', [
        'marca' => 'Patas & Cia',
        'fabricante' => 'Fabricante Pet',
    ]);
});

it('returns validation errors when brand details are missing', function () {
    $response = $this->from(route('marcas.index'))
        ->post(route('marcas.store'), [
            'marca' => 'Patas & Cia',
            'fabricante' => '',
        ]);

    $response->assertRedirect(route('marcas.index'))
        ->assertSessionHasErrors(['fabricante']);

    $this->assertDatabaseCount('marcas', 0);
});

it('shows saved categories and brands as product form options', function () {
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

    $response = $this->get(route('produtos.create'));

    $response->assertOk()
        ->assertSee('value="'.$categoriaId.'"', false)
        ->assertSee('data-categoria="Alimentação"', false)
        ->assertSee('value="'.$marcaId.'"', false)
        ->assertSee('Patas &amp; Cia', false);
});
