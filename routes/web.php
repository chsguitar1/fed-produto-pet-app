<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $produtos = DB::table('produtos')
        ->join('categorias', 'categorias.id', '=', 'produtos.categoria_id')
        ->join('marcas', 'marcas.id', '=', 'produtos.marca_id')
        ->leftJoin('lotes', 'lotes.id', '=', 'produtos.lote_id')
        ->select([
            'produtos.produto',
            'produtos.quantidade',
            'produtos.preco_custo',
            'produtos.preco_venda',
            'categorias.categoria',
            'marcas.marca',
            'lotes.numero_lote',
        ])
        ->orderByDesc('produtos.created_at')
        ->paginate(15);

    return view('dashboard.home', compact('produtos'));
})->name('home');

Route::get('/cadastrar-produto', function () {
    $categorias = DB::table('categorias')
        ->select('id', 'categoria')
        ->orderBy('categoria')
        ->get();
    $marcas = DB::table('marcas')
        ->select('id', 'marca')
        ->orderBy('marca')
        ->get();

    return view('produtos.cadastrarProdutos', compact('categorias', 'marcas'));
})->name('produtos.create');

Route::get('/categorias', function () {
    $categorias = DB::table('categorias')
        ->orderBy('categoria')
        ->paginate(15);

    return view('categorias.index', compact('categorias'));
})->name('categorias.index');

Route::post('/categorias', function (Request $request) {
    $validated = $request->validate([
        'categoria' => ['required', 'string', 'max:255'],
        'estoque' => ['required', 'boolean'],
    ]);

    DB::table('categorias')->insert([
        'categoria' => $validated['categoria'],
        'estoque' => $request->boolean('estoque'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()
        ->route('categorias.index')
        ->with('success', 'Categoria cadastrada com sucesso!');
})->name('categorias.store');

Route::get('/marcas', function () {
    $marcas = DB::table('marcas')
        ->orderBy('marca')
        ->paginate(15);

    return view('marcas.index', compact('marcas'));
})->name('marcas.index');

Route::post('/marcas', function (Request $request) {
    $validated = $request->validate([
        'marca' => ['required', 'string', 'max:255'],
        'fabricante' => ['required', 'string', 'max:255'],
    ]);

    DB::table('marcas')->insert([
        'marca' => $validated['marca'],
        'fabricante' => $validated['fabricante'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()
        ->route('marcas.index')
        ->with('success', 'Marca cadastrada com sucesso!');
})->name('marcas.store');
