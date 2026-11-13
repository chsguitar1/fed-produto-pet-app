<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class MarcaController extends Controller
{
    public function index()
    {
        $lista = Marca::all()->sortBy('Marca')->values();

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

    public function create()
    {
        return view('marcas.create');
    }

    public function store(MarcaRequest $request)
    {
        Marca::create($request->validated());

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca cadastrada com sucesso!');
    }

    public function show(Marca $marca)
    {
        $marca->load('produtos');

        return view('marcas.show', compact('marca'));
    }

    public function edit(Marca $marca)
    {
        return view('marcas.edit', compact('marca'));
    }

    /**
     * Valida (MarcaRequest) e atualiza a marca.
     */
    public function update(MarcaRequest $request, Marca $marca)
    {
        $marca->update($request->validated());

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca atualizada com sucesso!');
    }

    /**
     * Remove a marca, a menos que existam produtos vinculados.
     */
    public function destroy(Marca $marca)
    {
        if ($marca->produtos()->exists()) {
            return back()->with('error', 'Esta marca possui produtos vinculados e não pode ser excluída.');
        }

        $marca->delete();

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca removida com sucesso!');
    }
}
