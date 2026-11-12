<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;

class MarcaController extends Controller
{
    /**
     * Lista as marcas com a quantidade de produtos de cada uma.
     */
    public function index()
    {
        $marcas = Marca::withCount('produtos')
            ->orderBy('marca')
            ->paginate(15);

        return view('marcas.index', compact('marcas'));
    }

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('marcas.create');
    }

    /**
     * Valida (MarcaRequest) e grava a nova marca.
     */
    public function store(MarcaRequest $request)
    {
        Marca::create($request->validated());

        return redirect()
            ->route('marcas.index')
            ->with('success', 'Marca cadastrada com sucesso!');
    }

    /**
     * Mostra os detalhes da marca e os produtos vinculados a ela.
     */
    public function show(Marca $marca)
    {
        $marca->load('produtos');

        return view('marcas.show', compact('marca'));
    }

    /**
     * Exibe o formulário de edição já preenchido.
     */
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
