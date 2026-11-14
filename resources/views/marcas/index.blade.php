@extends('layouts.default')

@section('title', 'Marcas')
@section('page-title', 'Marcas')
@section('page-icon')
    <i class="fa-solid fa-tags text-primary"></i>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Marcas</li>
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
                        <i class="fa-solid fa-plus-circle text-primary"></i>
                        <span>Nova marca</span>
                    </h2>
                </div>
                <div class="card-body">
                    <p class="text-body-secondary small mb-3">
                        Cadastre uma marca para selecioná-la ao adicionar produtos.
                    </p>

                    <form method="POST" action="{{ route('marcas.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="marca" class="form-label fw-semibold text-body-emphasis">
                                <i class="fa-solid fa-tag text-body-secondary me-1"></i> Nome da marca <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="marca"
                                name="marca"
                                class="form-control @error('marca') is-invalid @enderror"
                                value="{{ old('marca') }}"
                                placeholder="Ex.: Patas & Cia"
                                maxlength="255"
                                required
                            >
                            @error('marca')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="fabricante" class="form-label fw-semibold text-body-emphasis">
                                <i class="fa-solid fa-industry text-body-secondary me-1"></i> Fabricante <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="fabricante"
                                name="fabricante"
                                class="form-control @error('fabricante') is-invalid @enderror"
                                value="{{ old('fabricante') }}"
                                placeholder="Ex.: Nome do fabricante"
                                maxlength="255"
                                required
                            >
                            <div class="form-text small text-body-secondary">Este campo é obrigatório.</div>
                            @error('fabricante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                            <i class="fa-solid fa-check"></i>
                            <span>Cadastrar marca</span>
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
                        <i class="fa-solid fa-tags text-primary"></i>
                        <span>Marcas cadastradas</span>
                    </h2>
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                        {{ $marcas->total() }} {{ $marcas->total() === 1 ? 'marca' : 'marcas' }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="border-bottom border-secondary-subtle">
                                <tr>
                                    <th scope="col" class="ps-3 text-body-secondary"><i class="fa-solid fa-tag me-1"></i> Marca</th>
                                    <th scope="col" class="text-body-secondary"><i class="fa-solid fa-industry me-1"></i> Fabricante</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($marcas as $marca)
                                    <tr>
                                        <td class="fw-semibold text-body-emphasis ps-3">
                                            <i class="fa-solid fa-tag text-body-secondary opacity-50 me-2"></i>{{ $marca->marca }}
                                        </td>
                                        <td>
                                            <span class="text-body-secondary">
                                                <i class="fa-solid fa-building text-body-tertiary small me-1"></i>{{ $marca->fabricante }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-5 text-center text-body-secondary">
                                            <div class="my-3">
                                                <i class="fa-solid fa-tags fa-2x mb-2 text-body-secondary opacity-50 d-block"></i>
                                                <p class="mb-0">Nenhuma marca cadastrada.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($marcas->hasPages())
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap gap-2 py-3 bg-transparent border-top border-secondary-subtle">
                        <div class="small text-body-secondary">
                            Página {{ $marcas->currentPage() }} de {{ $marcas->lastPage() }}
                        </div>
                        <div>
                            {{ $marcas->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--end::Table Col-->
    </div>
@endsection
