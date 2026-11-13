<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function index()
    {
        $lista = Produto::all()
            ->sortByDesc('created_at')
            ->map(function ($produto) {
                $categoria = Categoria::find($produto->categoria_id);
                $marca = Marca::find($produto->marca_id);
                $lote = Lote::find($produto->lote_id);

                return (object) [
                    'produto' => $produto->produto,
                    'quantidade' => $produto->quantidade,
                    'preco_custo' => $produto->preco_custo,
                    'preco_venda' => $produto->preco_venda,
                    'categoria' => $categoria?->categoria,
                    'marca' => $marca?->marca,
                    'numero_lote' => $lote?->numero_lote,
                ];
            })
            ->values();

        $porPagina = 15;
        $pagina = Paginator::resolveCurrentPage();

        $produtos = new LengthAwarePaginator(
            $lista->forPage($pagina, $porPagina)->values(),
            $lista->count(),
            $porPagina,
            $pagina,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('dashboard.home', compact('produtos'));
    }
}
