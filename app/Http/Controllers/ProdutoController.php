<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;

class ProdutoController extends Controller
{
    /**
     * Lista os produtos já com marca, categoria e lote carregados
     * (eager loading evita o problema de N+1 consultas).
     */
    public function index()
    {
        $produtos = Produto::with(['marca', 'categoria', 'lote'])
            ->latest()
            ->paginate(15);

        return view('produtos.index', compact('produtos'));
    }

    /**
     * Exibe o formulário de cadastro com os dados dos selects.
     */
    public function create()
    {
        return view('produtos.create', $this->dadosDoFormulario());
    }

    /**
     * Valida (ProdutoRequest) e grava o produto.
     *
     * $request->dados() aplica a regra de negócio: se a categoria
     * não controla estoque (serviço), quantidade vira 0 e lote_id vira null.
     */
    public function store(ProdutoRequest $request)
    {
        Produto::create($request->dados());

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

    /**
     * Mostra os detalhes de um produto com seus relacionamentos.
     */
    public function show(Produto $produto)
    {
        $produto->load(['marca', 'categoria', 'lote']);

        return view('produtos.show', compact('produto'));
    }

    /**
     * Exibe o formulário de edição preenchido.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', array_merge(
            ['produto' => $produto],
            $this->dadosDoFormulario()
        ));
    }

    /**
     * Valida (ProdutoRequest) e atualiza o produto.
     */
    public function update(ProdutoRequest $request, Produto $produto)
    {
        $produto->update($request->dados());

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove o produto.
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()
            ->route('produtos.index')
            ->with('success', 'Produto removido com sucesso!');
    }

    /**
     * Dados usados pelos selects dos formulários de create e edit.
     */
    private function dadosDoFormulario(): array
    {
        return [
            'marcas' => Marca::orderBy('marca')->get(),
            'categorias' => Categoria::orderBy('categoria')->get(),
            'lotes' => Lote::orderBy('numero_lote')->get(),
        ];
    }
}
