@extends('layouts.default')

@section('title', 'Categorias')
@section('page-title', 'Categorias')

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
                    <h2 class="card-title">Nova categoria</h2>
                </div>
                <div class="card-body">
                    <p class="text-body-secondary">
                        Cadastre uma categoria para selecioná-la ao adicionar produtos.
                    </p>

                    <form method="POST" action="{{ route('categorias.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="categoria" class="form-label">Nome da categoria</label>
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
                            <div class="form-text">
                                Para habilitar a validade em produtos, use “Alimentação” ou outro nome com “aliment”.
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
                                @checked(old('estoque'))
                            >
                            <label for="estoque" class="form-check-label">
                                Controla estoque <span class="text-danger">*</span>
                            </label>
                            <div class="form-text">
                                Selecione se esta categoria deve controlar estoque. Desmarcado significa “Não”.
                            </div>
                            @error('estoque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Cadastrar categoria
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Categorias cadastradas</h2>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Categoria</th>
                                    <th scope="col">Controle de estoque</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categorias as $categoria)
                                    <tr>
                                        <td>{{ $categoria->categoria }}</td>
                                        <td>{{ $categoria->estoque ? 'Sim' : 'Não' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="py-4 text-center text-body-secondary">
                                            Nenhuma categoria cadastrada.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($categorias->hasPages())
                    <div class="card-footer">
                        {{ $categorias->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
