@extends('layouts.default')

@section('title', 'Cadastrar produto')
@section('page-title', 'Cadastrar produto')

@section('content')
    <style>
        .product-registration {
            max-width: 1040px;
            margin: 0 auto;
        }

        .product-registration__intro {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .product-registration__intro-icon,
        .product-registration__section-icon {
            display: inline-flex;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            color: var(--bs-primary);
            background: rgba(var(--bs-primary-rgb), 0.1);
        }

        .product-registration__intro-icon {
            width: 3.5rem;
            height: 3.5rem;
            border-radius: 1rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .product-registration__card {
            overflow: hidden;
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1.75rem rgba(33, 37, 41, 0.08);
        }

        .product-registration__card-header {
            padding: 1.25rem 1.5rem;
            background: var(--bs-body-bg);
            border-bottom: 1px solid var(--bs-border-color);
        }

        .product-registration__section + .product-registration__section {
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--bs-border-color);
        }

        .product-registration__section-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .product-registration__section-icon {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.7rem;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .product-registration .form-label {
            font-weight: 500;
        }

        .product-registration .form-control {
            min-height: 2.9rem;
            border-radius: 0.65rem;
        }

        .product-registration__actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            margin-top: 1.75rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--bs-border-color);
        }

        .product-registration__submit {
            min-height: 2.9rem;
            padding: 0.65rem 1.25rem;
            border-radius: 0.65rem;
            font-weight: 600;
        }

        @media (max-width: 575.98px) {
            .product-registration__intro {
                gap: 0.75rem;
            }

            .product-registration__intro-icon {
                width: 3rem;
                height: 3rem;
            }

            .product-registration__card-header,
            .product-registration__card-body {
                padding: 1rem;
            }

            .product-registration__actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }
        }
    </style>

    <div class="product-registration py-2">
        <header class="product-registration__intro">
            <div class="product-registration__intro-icon" aria-hidden="true">+</div>
            <div>
                <span class="badge text-bg-primary-subtle text-primary-emphasis mb-2">Estoque</span>
                <h2 class="h4 mb-1">Novo produto</h2>
                <p class="text-body-secondary mb-0">
                    Informe os dados do produto para organizar seu catálogo e estoque.
                </p>
            </div>
        </header>

        <div class="card product-registration__card">
            <div class="card-header product-registration__card-header">
                <h3 class="h6 mb-0">Dados do cadastro</h3>
                <p class="small text-body-secondary mb-0 mt-1">
                    Os campos marcados como obrigatórios precisam ser preenchidos.
                </p>
            </div>

            <div class="card-body product-registration__card-body p-4">
                <form method="POST" action="{{ route('produtos.store') }}">
                    @csrf

                    <section class="product-registration__section" aria-labelledby="product-details-heading">
                        <h4 id="product-details-heading" class="product-registration__section-title">
                            <span class="product-registration__section-icon" aria-hidden="true">01</span>
                            Identificação do produto
                        </h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Categoria do produto <span class="text-danger">*</span></label>
                                <select
                                    id="categoria"
                                    name="categoria_id"
                                    class="form-select"
                                    required
                                >
                                    <option value="" disabled @selected(old('categoria_id') === null)>Selecione uma categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option
                                            value="{{ $categoria->id }}"
                                            data-categoria="{{ $categoria->categoria }}"
                                            @selected(old('categoria_id') == $categoria->id)
                                        >
                                            {{ $categoria->categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($categorias->isEmpty())
                                    <div class="form-text">
                                        Nenhuma categoria cadastrada.
                                        <a href="{{ route('categorias.index') }}">Cadastrar categoria</a>
                                    </div>
                                @else
                                    <div class="form-text">Escolha uma categoria cadastrada.</div>
                                @endif
                            </div>

                            <div class="col-md-6">
                                <label for="marca" class="form-label">Marca do produto <span class="text-danger">*</span></label>
                                <select
                                    id="marca"
                                    name="marca_id"
                                    class="form-select"
                                    required
                                >
                                    <option value="" disabled @selected(old('marca_id') === null)>Selecione uma marca</option>
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}" @selected(old('marca_id') == $marca->id)>
                                            {{ $marca->marca }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($marcas->isEmpty())
                                    <div class="form-text">
                                        Nenhuma marca cadastrada.
                                        <a href="{{ route('marcas.index') }}">Cadastrar marca</a>
                                    </div>
                                @else
                                    <div class="form-text">Escolha uma marca cadastrada.</div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label for="produto" class="form-label">Nome do produto <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="produto"
                                    name="produto"
                                    class="form-control"
                                    value="{{ old('produto') }}"
                                    placeholder="Ex.: Ração para cães adultos"
                                    maxlength="255"
                                    required
                                >
                            </div>
                        </div>
                    </section>

                    <section class="product-registration__section" aria-labelledby="stock-details-heading">
                        <h4 id="stock-details-heading" class="product-registration__section-title">
                            <span class="product-registration__section-icon" aria-hidden="true">02</span>
                            Estoque e preços
                        </h4>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="quantidade" class="form-label">Quantidade <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    id="quantidade"
                                    name="quantidade"
                                    class="form-control"
                                    value="{{ old('quantidade') }}"
                                    min="0"
                                    step="1"
                                    placeholder="0"
                                    required
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="preco_custo" class="form-label">Preço de compra <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input
                                        type="number"
                                        id="preco_custo"
                                        name="preco_custo"
                                        class="form-control"
                                        value="{{ old('preco_custo') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0,00"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="preco_venda" class="form-label">Preço de venda <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">R$</span>
                                    <input
                                        type="number"
                                        id="preco_venda"
                                        name="preco_venda"
                                        class="form-control"
                                        value="{{ old('preco_venda') }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0,00"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="product-registration__section" aria-labelledby="batch-details-heading">
                        <h4 id="batch-details-heading" class="product-registration__section-title">
                            <span class="product-registration__section-icon" aria-hidden="true">03</span>
                            Lote e validade
                        </h4>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="lote" class="form-label">Lote do produto <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="lote"
                                    name="lote"
                                    class="form-control"
                                    value="{{ old('lote') }}"
                                    maxlength="255"
                                    placeholder="Ex.: LT-2026-001"
                                    required
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="data_fabricacao" class="form-label">Data de fabricação <span class="text-danger">*</span></label>
                                <input
                                    type="date"
                                    id="data_fabricacao"
                                    name="data_fabricacao"
                                    class="form-control"
                                    value="{{ old('data_fabricacao') }}"
                                    required
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="data_validade" class="form-label">Data de validade</label>
                                <input
                                    type="date"
                                    id="data_validade"
                                    name="data_validade"
                                    class="form-control"
                                    value="{{ old('data_validade') }}"
                                    aria-describedby="data-validade-ajuda"
                                    disabled
                                >
                            </div>

                            <div class="col-12">
                                <div id="data-validade-ajuda" class="form-text" aria-live="polite">
                                    A validade fica disponível para categorias alimentícias, como Alimentação ou Alimentício.
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="product-registration__actions">
                        <p class="small text-body-secondary mb-0">
                            <span class="text-danger">*</span> Campos obrigatórios
                        </p>
                        <button type="submit" class="btn btn-primary product-registration__submit">
                            Cadastrar produto
                        </button>
                    </div>
                </form>

                <script>
                    const categoriaProduto = document.getElementById('categoria');
                    const dataValidade = document.getElementById('data_validade');
                    const ajudaDataValidade = document.getElementById('data-validade-ajuda');

                    const atualizarDisponibilidadeDaValidade = () => {
                        const categoriaSelecionada = categoriaProduto.options[categoriaProduto.selectedIndex];
                        const categoria = (categoriaSelecionada?.dataset.categoria ?? '')
                            .normalize('NFD')
                            .replace(/[\u0300-\u036f]/g, '')
                            .toLowerCase();
                        const categoriaAlimenticia = categoria.includes('aliment');

                        dataValidade.disabled = !categoriaAlimenticia;

                        if (!categoriaAlimenticia) {
                            dataValidade.value = '';
                        }

                        ajudaDataValidade.textContent = categoriaAlimenticia
                            ? 'Categoria alimentícia: informe a data de validade do produto.'
                            : 'A validade fica disponível para categorias alimentícias, como Alimentação ou Alimentício.';
                    };

                    categoriaProduto.addEventListener('change', atualizarDisponibilidadeDaValidade);
                    atualizarDisponibilidadeDaValidade();
                </script>
            </div>
        </div>
    </div>
@endsection
