<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MarcaController extends Controller
{
    public function index()
    {
        $lista = Marca::all()->sortBy('marca')->values();

        $porPagina = 15;
        $pagina = Paginator::resolveCurrentPage();

        $marcas = new LengthAwarePaginator(
            $lista->forPage($pagina, $porPagina)->values(),
            $lista->count(),
            $porPagina,
            $pagina,
            ['path' => Paginator::resolveCurrentPath()]
        );

        return view('marcas.index', compact('marcas'));
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'marca' => ['required', 'string', 'max:255'],
            'fabricante' => ['required', 'string', 'max:255'],
        ]);

        Marca::create($dados);

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca cadastrada com sucesso!');
    }
}
