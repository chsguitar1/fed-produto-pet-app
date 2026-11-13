@extends('layouts.default')

@section('title', 'Marcas')
@section('page-title', 'Marcas')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h2 class="card-title">Nova marca</h2>
                </div>
                <div class="card-body">
                    <p class="text-body-secondary">
                        Cadastre uma marca para selecioná-la ao adicionar produtos.
                    </p>

                    <form method="POST" action="{{ route('marcas.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="marca" class="form-label">Nome da marca</label>
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
                            <label for="fabricante" class="form-label">
                                Fabricante <span class="text-danger">*</span>
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
                            <div class="form-text">Este campo é obrigatório.</div>
                            @error('fabricante')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Cadastrar marca
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Marcas cadastradas</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Marca</th>
                                    <th scope="col">Fabricante</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($marcas as $marca)
                                    <tr>
                                        <td>{{ $marca->marca }}</td>
                                        <td>{{ $marca->fabricante }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-4 text-center text-body-secondary">
                                            Nenhuma marca cadastrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($marcas->hasPages())
                    <div class="card-footer">
                        {{ $marcas->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
