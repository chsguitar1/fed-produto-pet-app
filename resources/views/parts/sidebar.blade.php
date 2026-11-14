<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-link text-decoration-none d-flex align-items-center">
            <span class="brand-image d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 shadow-sm me-2" style="width: 32px; height: 32px;">
                <i class="fa-solid fa-paw"></i>
            </span>
            <span class="brand-text fw-bold text-white tracking-wide">PetShop</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Navegação principal">
            <ul class="nav sidebar-menu flex-column" id="navigation">
                <li class="nav-header text-uppercase text-secondary small fw-semibold">Gestão de Estoque</li>
                <li class="nav-item">
                    <a
                        href="{{ route('home') }}"
                        @class(['nav-link', 'active' => request()->routeIs('home')])
                        @if (request()->routeIs('home')) aria-current="page" @endif
                    >
                        <i class="nav-icon fa-solid fa-boxes-stacked" aria-hidden="true"></i>
                        <p>Produtos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('produtos.create') }}"
                        @class(['nav-link', 'active' => request()->routeIs('produtos.create')])
                        @if (request()->routeIs('produtos.create')) aria-current="page" @endif
                    >
                        <i class="nav-icon fa-solid fa-circle-plus" aria-hidden="true"></i>
                        <p>Novo Produto</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase text-secondary small fw-semibold mt-2">Catálogo & Parâmetros</li>
                <li class="nav-item">
                    <a
                        href="{{ route('categorias.index') }}"
                        @class(['nav-link', 'active' => request()->routeIs('categorias.*')])
                        @if (request()->routeIs('categorias.*')) aria-current="page" @endif
                    >
                        <i class="nav-icon fa-solid fa-layer-group" aria-hidden="true"></i>
                        <p>Categorias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('marcas.index') }}"
                        @class(['nav-link', 'active' => request()->routeIs('marcas.*')])
                        @if (request()->routeIs('marcas.*')) aria-current="page" @endif
                    >
                        <i class="nav-icon fa-solid fa-tags" aria-hidden="true"></i>
                        <p>Marcas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
