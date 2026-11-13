<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    /**
     * Lista as categorias com a quantidade de produtos de cada uma.
     */
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

    /**
     * Exibe o formulário de cadastro.
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Valida (CategoriaRequest) e grava a nova categoria.
     *
     * O checkbox "estoque" não envia nada quando desmarcado,
     * por isso o valor é convertido com $request->boolean().
     */
    public function store(CategoriaRequest $request)
    {
        $dados = $request->validated();
        $dados['estoque'] = $request->boolean('estoque');

        Categoria::create($dados);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria cadastrada com sucesso!');
    }

    /**
     * Mostra os detalhes da categoria e os produtos vinculados a ela.
     */
    public function show(Categoria $categoria)
    {
        $categoria->load('produtos');

        return view('categorias.show', compact('categoria'));
    }

    /**
     * Exibe o formulário de edição já preenchido.
     */
    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    /**
     * Valida (CategoriaRequest) e atualiza a categoria.
     *
     * Se a categoria já tem produtos, não permite trocar o tipo
     * (produto físico <-> serviço), pois isso deixaria os produtos
     * com lote/quantidade inconsistentes.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $dados = $request->validated();
        $dados['estoque'] = $request->boolean('estoque');

        $trocouTipo = $dados['estoque'] !== $categoria->estoque;

        if ($trocouTipo && $categoria->produtos()->exists()) {
            return back()
                ->withInput()
                ->with('error', 'Não é possível alterar o controle de estoque de uma categoria que já possui produtos.');
        }

        $categoria->update($dados);

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove a categoria, a menos que existam produtos vinculados.
     */
    public function destroy(Categoria $categoria)
    {
        if ($categoria->produtos()->exists()) {
            return back()->with('error', 'Esta categoria possui produtos vinculados e não pode ser excluída.');
        }

        $categoria->delete();

        return redirect()
            ->route('categorias.index')
            ->with('success', 'Categoria removida com sucesso!');
    }
}
