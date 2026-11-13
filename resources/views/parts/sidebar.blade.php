<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="{{ route('home') }}" class="brand-link">
            <span class="brand-image d-inline-flex align-items-center justify-content-center opacity-75">
                <i class="bi bi-heart-pulse-fill" aria-hidden="true"></i>
            </span>
            <span class="brand-text fw-light">PetShop</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Navegação principal">
            <ul class="nav sidebar-menu flex-column" id="navigation">
                <li class="nav-header">MENU PRINCIPAL</li>
                <li class="nav-item">
                    <a
                        href="{{ route('home') }}"
                        @class(['nav-link', 'active' => request()->routeIs('home')])
                        @if (request()->routeIs('home')) aria-current="page" @endif
                    >
                        <i class="nav-icon bi bi-house-door" aria-hidden="true"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('categorias.index') }}"
                        @class(['nav-link', 'active' => request()->routeIs('categorias.*')])
                        @if (request()->routeIs('categorias.*')) aria-current="page" @endif
                    >
                        <i class="nav-icon bi bi-grid" aria-hidden="true"></i>
                        <p>Categorias</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('marcas.index') }}"
                        @class(['nav-link', 'active' => request()->routeIs('marcas.*')])
                        @if (request()->routeIs('marcas.*')) aria-current="page" @endif
                    >
                        <i class="nav-icon bi bi-tag" aria-hidden="true"></i>
                        <p>Marcas</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
