@extends('layouts.default')

@section('title', 'Produtos')
@section('page-title', 'Produtos')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h2 class="card-title">Produtos cadastrados</h2>
                <p class="small text-body-secondary mb-0 mt-1">
                    {{ $produtos->count() }} {{ $produtos->count() === 1 ? 'produto encontrado' : 'produtos encontrados' }}
                </p>
            </div>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                Cadastrar produto
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Produto</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Lote</th>
                            <th scope="col">Preço de compra</th>
                            <th scope="col">Preço de venda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $produto)
                            <tr>
                                <td class="fw-semibold">{{ $produto->produto }}</td>
                                <td>{{ $produto->categoria }}</td>
                                <td>{{ $produto->marca }}</td>
                                <td>{{ $produto->quantidade }}</td>
                                <td>{{ $produto->numero_lote ?? '—' }}</td>
                                <td>R$ {{ number_format((float) $produto->preco_custo, 2, ',', '.') }}</td>
                                <td>R$ {{ number_format((float) $produto->preco_venda, 2, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-center">
                                    <p class="fw-semibold mb-1">Nenhum produto cadastrado.</p>
                                    <p class="text-body-secondary mb-3">
                                        Cadastre seu primeiro produto para acompanhar seu estoque por aqui.
                                    </p>
                                    <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                                        Cadastrar primeiro produto
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
