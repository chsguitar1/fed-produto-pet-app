<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cadastrar-produto', [ProdutoController::class, 'create'])->name('produtos.create');
Route::post('/cadastrar-produto', [ProdutoController::class, 'store'])->name('produtos.store');

Route::resource('categorias', CategoriaController::class)->only(['index', 'store']);
Route::resource('marcas', MarcaController::class)->only(['index', 'store']);
