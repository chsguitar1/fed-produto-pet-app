# Controllers: Produtos, Marcas e Categorias

Documentação dos controllers do módulo de cadastro de produtos do petshop.

Os três controllers seguem o mesmo padrão **resource**: sete métodos (`index`, `create`, `store`, `show`, `edit`, `update`, `destroy`) que retornam **views Blade** ou **redirecionam** com mensagem flash.

---

## Como o controller conecta tudo

```
Rota (routes/web.php)
   └─> Controller
          ├─> Form Request ........ valida os dados (store/update)
          ├─> Model ............... lê e grava no banco
          └─> View Blade .......... mostra o resultado (ou redirect + flash)
```

Fluxo de um cadastro de produto (`POST /produtos`):

1. A rota `Route::resource('produtos', ProdutoController::class)` envia a requisição para `ProdutoController@store`.
2. O Laravel instancia `ProdutoRequest` e valida antes de entrar no método. Se falhar, volta ao formulário com `$errors` e `old()`.
3. O controller chama `Produto::create($request->dados())`.
4. Faz `redirect()->route('produtos.index')->with('success', ...)`.
5. O layout Blade exibe a mensagem com `session('success')`.

### Dependências de outras partes do projeto

Estes itens são responsabilidade dos colegas. Os controllers só esperam que existam com estes nomes:

| Item | Quem usa | O que o controller espera |
|---|---|---|
| `App\Models\Marca` | Marca, Produto | `$fillable`, relação `produtos()` |
| `App\Models\Categoria` | Categoria, Produto | `$fillable`, cast `estoque` boolean, relação `produtos()` |
| `App\Models\Lote` | Produto | model com a coluna `numero_lote` (usado só no select) |
| `App\Models\Produto` | Produto | `$fillable`, relações `marca()`, `categoria()`, `lote()` |
| `MarcaRequest`, `CategoriaRequest`, `ProdutoRequest` | cada controller | `authorize()` retornando `true`; o `ProdutoRequest` deve ter o método `dados()` |
| Rotas `Route::resource(...)` | todos | nomes padrão (`produtos.index`, `marcas.index` etc.) |
| Views em `resources/views/{recurso}/` | todos | `index`, `create`, `edit`, `show` |

---

## MarcaController

**Arquivo:** `app/Http/Controllers/MarcaController.php`

**Responsabilidade:** CRUD de marcas (`marca`, `fabricante`).

| Método | Rota | O que faz | Retorno |
|---|---|---|---|
| `index` | GET `/marcas` | Lista marcas com a contagem de produtos | view `marcas.index` |
| `create` | GET `/marcas/create` | Mostra o formulário vazio | view `marcas.create` |
| `store` | POST `/marcas` | Valida e grava | redirect para `marcas.index` |
| `show` | GET `/marcas/{marca}` | Detalha a marca e seus produtos | view `marcas.show` |
| `edit` | GET `/marcas/{marca}/edit` | Formulário preenchido | view `marcas.edit` |
| `update` | PUT `/marcas/{marca}` | Valida e atualiza | redirect para `marcas.index` |
| `destroy` | DELETE `/marcas/{marca}` | Remove, se não houver produtos | redirect com sucesso ou `back()` com erro |

**Exemplo de conexão (listagem):**

```php
$marcas = Marca::withCount('produtos')->orderBy('marca')->paginate(15);
return view('marcas.index', compact('marcas'));
```

```blade
{{-- resources/views/marcas/index.blade.php --}}
@foreach ($marcas as $marca)
    {{ $marca->marca }} ({{ $marca->produtos_count }} produtos)
@endforeach
{{ $marcas->links() }}
```

**Exemplo de proteção na exclusão:**

```php
if ($marca->produtos()->exists()) {
    return back()->with('error', 'Esta marca possui produtos vinculados e não pode ser excluída.');
}
```

---

## CategoriaController

**Arquivo:** `app/Http/Controllers/CategoriaController.php`

**Responsabilidade:** CRUD de categorias (`categoria`, `estoque`). O campo `estoque` define o tipo: `true` = produto físico (com quantidade e lote), `false` = serviço.

| Método | Rota | O que faz | Retorno |
|---|---|---|---|
| `index` | GET `/categorias` | Lista categorias com contagem de produtos | view `categorias.index` |
| `create` | GET `/categorias/create` | Formulário vazio | view `categorias.create` |
| `store` | POST `/categorias` | Valida, converte o checkbox e grava | redirect para `categorias.index` |
| `show` | GET `/categorias/{categoria}` | Detalha a categoria e seus produtos | view `categorias.show` |
| `edit` | GET `/categorias/{categoria}/edit` | Formulário preenchido | view `categorias.edit` |
| `update` | PUT `/categorias/{categoria}` | Valida e atualiza; bloqueia troca do tipo se houver produtos | redirect ou `back()` com erro |
| `destroy` | DELETE `/categorias/{categoria}` | Remove, se não houver produtos | redirect ou `back()` com erro |

**Exemplo: checkbox desmarcado não é enviado pelo navegador**

```php
$dados = $request->validated();
$dados['estoque'] = $request->boolean('estoque'); // ausente = false
Categoria::create($dados);
```

**Exemplo: proteção ao trocar o tipo da categoria**

```php
$trocouTipo = $dados['estoque'] !== $categoria->estoque;

if ($trocouTipo && $categoria->produtos()->exists()) {
    return back()->withInput()->with('error', 'Não é possível alterar o controle de estoque ...');
}
```

Por que isso existe: se uma categoria de produtos físicos virasse "serviço" com produtos já cadastrados, eles ficariam com lote e quantidade que não fazem sentido.

---

## ProdutoController

**Arquivo:** `app/Http/Controllers/ProdutoController.php`

**Responsabilidade:** CRUD de produtos (`produto`, `quantidade`, `preco_custo`, `preco_venda`, `lote_id`, `categoria_id`, `marca_id`). É o controller que mais se conecta com os outros módulos.

| Método | Rota | O que faz | Retorno |
|---|---|---|---|
| `index` | GET `/produtos` | Lista produtos com marca, categoria e lote carregados | view `produtos.index` |
| `create` | GET `/produtos/create` | Formulário com selects de marca, categoria e lote | view `produtos.create` |
| `store` | POST `/produtos` | Valida e grava aplicando a regra de estoque/serviço | redirect para `produtos.index` |
| `show` | GET `/produtos/{produto}` | Detalha o produto e suas relações | view `produtos.show` |
| `edit` | GET `/produtos/{produto}/edit` | Formulário preenchido com os selects | view `produtos.edit` |
| `update` | PUT `/produtos/{produto}` | Valida e atualiza | redirect para `produtos.index` |
| `destroy` | DELETE `/produtos/{produto}` | Remove o produto | redirect para `produtos.index` |

**Exemplo: eager loading na listagem (evita N+1)**

```php
$produtos = Produto::with(['marca', 'categoria', 'lote'])->latest()->paginate(15);
```

```blade
@foreach ($produtos as $p)
    {{ $p->produto }} | {{ $p->marca->marca }} | {{ $p->categoria->categoria }}
    | {{ $p->categoria->estoque ? $p->quantidade : 'Serviço' }}
@endforeach
```

**Exemplo: dados dos selects (método privado reaproveitado em `create` e `edit`)**

```php
private function dadosDoFormulario(): array
{
    return [
        'marcas'     => Marca::orderBy('marca')->get(),
        'categorias' => Categoria::orderBy('categoria')->get(),
        'lotes'      => Lote::orderBy('numero_lote')->get(),
    ];
}
```

```blade
<select name="marca_id">
    @foreach ($marcas as $m)
        <option value="{{ $m->id }}" @selected(old('marca_id', $produto->marca_id ?? '') == $m->id)>
            {{ $m->marca }}
        </option>
    @endforeach
</select>
```

**Exemplo: regra de negócio estoque x serviço**

O controller não decide a regra: ele delega ao `ProdutoRequest`.

```php
// ProdutoController
Produto::create($request->dados());

// ProdutoRequest (feito pelo colega responsável)
public function dados(): array
{
    $dados = $this->validated();

    if (! Categoria::findOrFail($dados['categoria_id'])->estoque) {
        $dados['quantidade'] = 0;
        $dados['lote_id']    = null;
    }

    return $dados;
}
```

---

## Resumo das regras de negócio nos controllers

- **Marca e Categoria** não podem ser excluídas se tiverem produtos (também há `restrictOnDelete` nas chaves estrangeiras como segunda barreira).
- **Categoria** não pode trocar o campo `estoque` se já tiver produtos.
- **Produto** de categoria sem estoque (serviço) é gravado com `quantidade = 0` e `lote_id = null`.
- Toda gravação usa Form Request (`validated()`), nunca `$request->all()`.
- Toda resposta de gravação ou exclusão é um `redirect` com `success` ou `error`, exibido no layout.

## Rotas necessárias (`routes/web.php`)

```php
Route::resource('marcas', MarcaController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('produtos', ProdutoController::class);
```

## Checklist para testar a integração

1. `php artisan route:list` mostra as rotas `marcas.*`, `categorias.*` e `produtos.*`.
2. Cadastrar uma marca e uma categoria, depois um produto usando ambas.
3. Tentar excluir a marca ou a categoria com produto vinculado: deve voltar com a mensagem de erro.
4. Tentar trocar o `estoque` de uma categoria que já tem produtos: deve ser bloqueado.
5. Cadastrar um produto de categoria "serviço" sem lote e sem quantidade: deve salvar.
