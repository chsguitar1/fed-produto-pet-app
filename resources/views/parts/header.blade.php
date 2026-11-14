<nav class="app-header navbar navbar-expand bg-body border-bottom border-secondary-subtle">
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav align-items-center">
            <li class="nav-item">
                <a class="nav-link text-body" data-lte-toggle="sidebar" href="#" role="button" aria-label="Alternar menu">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block ms-2">
                <a href="{{ route('home') }}" class="nav-link text-body-secondary d-flex align-items-center gap-2">
                    <i class="fa-solid fa-paw text-primary"></i>
                    <span class="fw-medium text-body">PetShop Gestão</span>
                </a>
            </li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto align-items-center gap-2">
            <!--begin::Theme Switcher-->
            <li class="nav-item dropdown">
                <button
                    class="btn btn-link nav-link text-body py-1 px-2 d-flex align-items-center gap-1 dropdown-toggle"
                    type="button"
                    aria-expanded="false"
                    data-bs-toggle="dropdown"
                    title="Alternar tema"
                >
                    <i class="fa-solid fa-moon text-primary" id="bd-theme-icon"></i>
                    <span class="d-none d-lg-inline small">Tema</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2 active" data-bs-theme-value="dark">
                            <i class="fa-solid fa-moon"></i> Escuro (Dark)
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="light">
                            <i class="fa-solid fa-sun"></i> Claro (Light)
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center gap-2" data-bs-theme-value="auto">
                            <i class="fa-solid fa-circle-half-stroke"></i> Automático
                        </button>
                    </li>
                </ul>
            </li>
            <!--end::Theme Switcher-->

            <li class="nav-item d-none d-sm-block">
                <a href="{{ route('produtos.create') }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-plus"></i>
                    <span>Novo Produto</span>
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-link text-body-secondary d-flex align-items-center gap-2 py-1 px-2">
                    <i class="fa-solid fa-circle-user text-primary fs-5"></i>
                    <span class="d-none d-md-inline small fw-medium text-body">Administrador</span>
                </span>
            </li>
        </ul>
        <!--end::End Navbar Links-->
    </div>
</nav>
