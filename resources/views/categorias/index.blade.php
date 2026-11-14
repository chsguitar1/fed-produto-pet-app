@extends('layouts.default')

@section('title', 'Categorias')
@section('page-title', 'Categorias')
@section('page-icon')
    <i class="fa-solid fa-layer-group text-primary"></i>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Categorias</li>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <div class="row g-4">
        <!--begin::Form Col-->
        <div class="col-lg-4">
            <div class="card bg-body-secondary border border-secondary-subtle card-primary card-outline shadow-sm">
                <div class="card-header bg-transparent py-3 border-bottom border-secondary-subtle">
                    <h2 class="card-title h5 mb-0 fw-bold d-flex align-items-center gap-2 text-body-emphasis">
                        <i class="fa-solid fa-folder-plus text-primary"></i>
                        <span>Nova categoria</span>
                    </h2>
                </div>
                <div class="card-body">
                    <p class="text-body-secondary small mb-3">
                        Cadastre uma categoria para selecioná-la ao adicionar produtos.
                    </p>

                    <form method="POST" action="{{ route('categorias.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="categoria" class="form-label fw-semibold text-body-emphasis">
                                <i class="fa-solid fa-folder text-body-secondary me-1"></i> Nome da categoria <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="categoria"
                                name="categoria"
                                class="form-control @error('categoria') is-invalid @enderror"
                                value="{{ old('categoria') }}"
                                placeholder="Ex.: Alimentação"
                                maxlength="255"
                                required
                            >
                            @error('categoria')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text d-flex align-items-center gap-1 mt-1 text-body-secondary">
                                <i class="fa-solid fa-circle-info text-primary"></i>
                                <span>Para habilitar a validade em produtos, use “Alimentação” ou outro nome com “aliment”.</span>
                            </div>
                        </div>

                        <div class="form-check form-switch mb-4">
                            <input type="hidden" name="estoque" value="0">
                            <input
                                type="checkbox"
                                id="estoque"
                                name="estoque"
                                value="1"
                                class="form-check-input @error('estoque') is-invalid @enderror"
                                role="switch"
                                @checked(old('estoque'))
                            >
                            <label for="estoque" class="form-check-label fw-semibold text-body-emphasis">
                                <i class="fa-solid fa-boxes-stacked text-body-secondary me-1"></i> Controla estoque <span class="text-danger">*</span>
                            </label>
                            <div class="form-text text-body-secondary">
                                Selecione se esta categoria deve controlar estoque. Desmarcado significa “Não”.
                            </div>
                            @error('estoque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="fa-solid fa-check"></i>
                            <span>Cadastrar categoria</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Form Col-->

        <!--begin::Table Col-->
        <div class="col-lg-8">
            <div class="card bg-body-secondary border border-secondary-subtle shadow-sm">
                <div class="card-header bg-transparent py-3 d-flex align-items-center justify-content-between border-bottom border-secondary-subtle">
                    <h2 class="card-title h5 mb-0 fw-bold d-flex align-items-center gap-2 text-body-emphasis">
                        <i class="fa-solid fa-layer-group text-primary"></i>
                        <span>Categorias cadastradas</span>
                    </h2>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                        {{ $categorias->total() }} {{ $categorias->total() === 1 ? 'categoria' : 'categorias' }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="border-bottom border-secondary-subtle">
                                <tr>
                                    <th scope="col" class="ps-3 text-body-secondary"><i class="fa-solid fa-folder me-1"></i> Categoria</th>
                                    <th scope="col" class="text-center text-body-secondary"><i class="fa-solid fa-boxes-stacked me-1"></i> Controle de estoque</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categorias as $categoria)
                                    <tr>
                                        <td class="fw-semibold text-body-emphasis ps-3">
                                            <i class="fa-solid fa-folder text-body-secondary opacity-50 me-2"></i>{{ $categoria->categoria }}
                                        </td>
                                        <td class="text-center">
                                            @if ($categoria->estoque)
                                                <span class="badge text-bg-success-subtle text-success-emphasis border border-success-subtle d-inline-flex align-items-center gap-1 px-2 py-1">
                                                    <i class="fa-solid fa-check"></i> Sim
                                                </span>
                                            @else
                                                <span class="badge text-bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle d-inline-flex align-items-center gap-1 px-2 py-1">
                                                    <i class="fa-solid fa-xmark"></i> Não
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-5 text-center text-body-secondary">
                                            <div class="my-3">
                                                <i class="fa-solid fa-layer-group fa-2x mb-2 text-body-secondary opacity-50 d-block"></i>
                                                <p class="mb-0">Nenhuma categoria cadastrada.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($categorias->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 bg-transparent border-top border-secondary-subtle">
                        <div class="small text-body-secondary">
                            Página {{ $categorias->currentPage() }} de {{ $categorias->lastPage() }}
                        </div>
                        <div>
                            {{ $categorias->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--end::Table Col-->
    </div>
@endsection
