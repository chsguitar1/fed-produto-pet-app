<div class="app-content-header py-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-sm-6">
                @hasSection('page-title')
                    <h1 class="mb-0 fs-3 fw-bold text-body-emphasis d-flex align-items-center gap-2">
                        @yield('page-icon')
                        <span>@yield('page-title')</span>
                    </h1>
                @endif
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-body-secondary">
                                <i class="fa-solid fa-house me-1"></i>Início
                            </a>
                        </li>
                        @hasSection('breadcrumb')
                            @yield('breadcrumb')
                        @else
                            <li class="breadcrumb-item active" aria-current="page">@yield('page-title', 'PetShop')</li>
                        @endif
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
