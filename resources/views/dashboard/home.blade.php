@extends('layouts.default')

@section('title', 'Produtos')
@section('page-title', 'Produtos')
@section('page-icon')
    <i class="fa-solid fa-boxes-stacked text-primary"></i>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Produtos</li>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <!--begin::Quick Stats-->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card bg-body-secondary border border-secondary-subtle shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-3 p-3 fs-3" style="width: 56px; height: 56px;">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <div class="text-body-secondary small fw-medium text-uppercase">Total de Produtos</div>
                        <div class="fs-4 fw-bold text-body-emphasis">{{ $produtos->total() }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card bg-body-secondary border border-secondary-subtle shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-3 p-3 fs-3" style="width: 56px; height: 56px;">
                        <i class="fa-solid fa-circle-plus"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="text-body-secondary small fw-medium text-uppercase">Cadastrar Estoque</div>
                        <a href="{{ route('produtos.create') }}" class="btn btn-sm btn-outline-success mt-1 d-inline-flex align-items-center gap-1">
                            <i class="fa-solid fa-plus"></i> Novo Produto
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card bg-body-secondary border border-secondary-subtle shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info rounded-3 p-3 fs-3" style="width: 56px; height: 56px;">
                        <i class="fa-solid fa-tags"></i>
                    </div>
                    <div>
                        <div class="text-body-secondary small fw-medium text-uppercase">Gestão do Catálogo</div>
                        <div class="d-flex gap-2 mt-1">
                            <a href="{{ route('categorias.index') }}" class="badge bg-body-tertiary border border-secondary-subtle text-body text-decoration-none">
                                <i class="fa-solid fa-layer-group me-1 text-primary"></i> Categorias
                            </a>
                            <a href="{{ route('marcas.index') }}" class="badge bg-body-tertiary border border-secondary-subtle text-body text-decoration-none">
                                <i class="fa-solid fa-tag me-1 text-primary"></i> Marcas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Quick Stats-->

    <div class="card bg-body-secondary border border-secondary-subtle shadow-sm">
        <div class="card-header bg-transparent py-3 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-secondary-subtle">
            <div>
                <h2 class="card-title h5 mb-0 fw-bold d-flex align-items-center gap-2 text-body-emphasis">
                    <i class="fa-solid fa-list-check text-primary"></i>
                    <span>Produtos cadastrados</span>
                </h2>
                <p class="small text-body-secondary mb-0 mt-1">
                    {{ $produtos->total() }} {{ $produtos->total() === 1 ? 'produto encontrado' : 'produtos encontrados' }}
                </p>
            </div>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-plus"></i>
                <span>Cadastrar produto</span>
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="border-bottom border-secondary-subtle">
                        <tr>
                            <th scope="col" class="ps-3 text-body-secondary"><i class="fa-solid fa-box me-1"></i> Produto</th>
                            <th scope="col" class="text-body-secondary"><i class="fa-solid fa-layer-group me-1"></i> Categoria</th>
                            <th scope="col" class="text-body-secondary"><i class="fa-solid fa-tag me-1"></i> Marca</th>
                            <th scope="col" class="text-center text-body-secondary"><i class="fa-solid fa-cubes-stacked me-1"></i> Quantidade</th>
                            <th scope="col" class="text-body-secondary"><i class="fa-solid fa-barcode me-1"></i> Lote</th>
                            <th scope="col" class="text-body-secondary"><i class="fa-solid fa-arrow-down me-1"></i> Preço de compra</th>
                            <th scope="col" class="text-body-secondary"><i class="fa-solid fa-arrow-up me-1"></i> Preço de venda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $produto)
                            <tr>
                                <td class="fw-semibold text-body-emphasis ps-3">{{ $produto->produto }}</td>
                                <td>
                                    <span class="badge bg-body-tertiary text-body border border-secondary-subtle">
                                        <i class="fa-solid fa-layer-group text-primary small me-1"></i>{{ $produto->categoria }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-body-secondary">
                                        <i class="fa-solid fa-tag text-body-tertiary small me-1"></i>{{ $produto->marca }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ((int) $produto->quantidade === 0)
                                        <span class="badge text-bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $produto->quantidade }}
                                        </span>
                                    @elseif ((int) $produto->quantidade <= 5)
                                        <span class="badge text-bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">
                                            <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $produto->quantidade }}
                                        </span>
                                    @else
                                        <span class="badge text-bg-success-subtle text-success-emphasis border border-success-subtle px-2 py-1">
                                            {{ $produto->quantidade }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($produto->numero_lote))
                                        <span class="badge bg-body-tertiary border border-secondary-subtle font-monospace text-body-secondary">
                                            <i class="fa-solid fa-barcode me-1"></i>{{ $produto->numero_lote }}
                                        </span>
                                    @else
                                        <span class="text-body-secondary">—</span>
                                    @endif
                                </td>
                                <td class="text-body-secondary">R$ {{ number_format((float) $produto->preco_custo, 2, ',', '.') }}</td>
                                <td class="fw-bold text-success-emphasis">R$ {{ number_format((float) $produto->preco_venda, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <div class="my-3">
                                        <div class="text-body-secondary opacity-50 mb-3">
                                            <i class="fa-solid fa-box-open fa-3x"></i>
                                        </div>
                                        <p class="fw-semibold fs-5 mb-1 text-body-emphasis">Nenhum produto cadastrado.</p>
                                        <p class="text-body-secondary mb-3">
                                            Cadastre seu primeiro produto para acompanhar seu estoque por aqui.
                                        </p>
                                        <a href="{{ route('produtos.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                                            <i class="fa-solid fa-plus"></i>
                                            <span>Cadastrar primeiro produto</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($produtos->hasPages())
            <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 bg-transparent border-top border-secondary-subtle">
                <div class="small text-body-secondary">
                    Página {{ $produtos->currentPage() }} de {{ $produtos->lastPage() }}
                </div>
                <div>
                    {{ $produtos->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
