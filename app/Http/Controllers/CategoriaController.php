<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class CategoriaController extends Controller
{
    public function index()
    {
        $lista = Categoria::all()->sortBy('categoria')->values();

        $porPagina = 15;
        $pagina = Paginator::resolveCurrentPage();

        $categorias = new LengthAwarePaginator(
            $lista->forPage($pagina, $porPagina)->values(),
            $lista->count(),
            $porPagina,
            $pagina,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria' => ['required', 'string', 'max:255'],
            'estoque' => ['nullable', 'boolean'],
        ]);

        $dados['estoque'] = $request->boolean('estoque');

        Categoria::create($dados);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }
}
