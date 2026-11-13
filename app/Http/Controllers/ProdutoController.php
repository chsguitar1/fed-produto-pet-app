<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categoria;
use App\Models\Lote;
use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function create()
    {
        return view('produtos.create', [
            'categorias' => Categoria::all(),
            'marcas' => Marca::all(),
        ]);
    }

    public function store(Request $request)
    {
        $dados = $request->validate([
            'categoria_id' => ['required', 'exists:categorias,id'],
            'marca_id' => ['required', 'exists:marcas,id'],
            'produto' => ['required', 'string', 'max:255'],
            'quantidade' => ['required', 'integer', 'min:0'],
            'preco_custo' => ['required', 'numeric', 'min:0'],
            'preco_venda' => ['required', 'numeric', 'min:0'],
            'lote' => ['required', 'string', 'max:255'],
            'data_fabricacao' => ['required', 'date'],
            'data_validade' => ['nullable', 'date', 'after_or_equal:data_fabricacao'],
        ]);

        // find: só categorias alimentícias guardam validade
        $categoria = Categoria::find($dados['categoria_id']);
        $dataValidade = stripos($categoria->categoria, 'aliment') !== false
            ? ($dados['data_validade'] ?? null)
            : null;

        // 1º grava o lote (tabela separada) com fabricação e validade
        $lote = Lote::create([
            'numero_lote' => $dados['lote'],
            'data_fabricacao' => $dados['data_fabricacao'],
            'data_validade' => $dataValidade,
        ]);

        // 2º grava o produto guardando só o id do lote
        Produto::create([
            'categoria_id' => $dados['categoria_id'],
            'marca_id' => $dados['marca_id'],
            'lote_id' => $lote->id,
            'produto' => $dados['produto'],
            'quantidade' => $dados['quantidade'],
            'preco_custo' => $dados['preco_custo'],
            'preco_venda' => $dados['preco_venda'],
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Produto cadastrado com sucesso!');
    }

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
