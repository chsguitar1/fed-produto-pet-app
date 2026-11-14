<!doctype html>
<html lang="pt-br" data-bs-theme="dark">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <title>@yield('title', 'PetShop') - Sistema de Gestão</title>

    @vite('resources/scss/app.scss')

    <!--begin::Theme Init (Default Dark Theme)-->
    <script>
      (() => {
        'use strict';
        const root = document.documentElement;

        const STORAGE_KEY = 'lte-theme';
        let stored = null;
        try {
          stored = localStorage.getItem(STORAGE_KEY);
        } catch {}

        // Precedence: stored choice > authored theme > 'dark' default
        const authored = root.getAttribute('data-bs-theme');
        let resolved = stored || authored || 'dark';

        root.setAttribute('data-bs-theme', resolved);
        root.style.colorScheme = resolved;
        if (resolved !== authored) {
          root.setAttribute('data-lte-theme-resolved', '');
        }
      })();
    </script>
    <!--end::Theme Init-->

    <!--begin::Meta Tags-->
    <meta name="color-scheme" content="dark light" />
    <meta name="theme-color" content="#1a1d20" />
    <meta name="description" content="PetShop - Sistema de Gestão de Produtos, Categorias e Marcas" />
    <!--end::Meta Tags-->

    <!--begin::Fonts & Icons-->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
      media="print"
      onload="this.media = 'all'"
    />
    <!-- FontAwesome 6 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <!-- Bootstrap Icons (fallback compatibility) -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      crossorigin="anonymous"
    />
    <!--end::Fonts & Icons-->

    @stack('styles')
  </head>
  <!--end::Head-->

  <!--begin::Body-->
  <body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    @vite('resources/js/app.js')

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      @include('parts.header')
      <!--end::Header-->

      <!--begin::Sidebar-->
      @include('parts.sidebar')
      <!--end::Sidebar-->

      <!--begin::App Main-->
      <main class="app-main">
        <!--begin::App Content Header-->
        @include('parts.content-header')
        <!--end::App Content Header-->

        <!--begin::App Content-->
        <div class="app-content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->

      <!--begin::Footer-->
      @include('parts.footer')
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->

    <!--begin::Third Party Scripts-->
    <script
      src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
      crossorigin="anonymous"
    ></script>
    <!--end::Third Party Scripts-->

    <!--begin::OverlayScrollbars & Theme Toggle Script-->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        const isMobile = window.innerWidth <= 992;

        if (
          sidebarWrapper &&
          typeof OverlayScrollbarsGlobal !== 'undefined' &&
          OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
          !isMobile
        ) {
          OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
              theme: 'os-theme-light',
              autoHide: 'leave',
              clickScroll: true,
            },
          });
        }

        // Theme Toggle Handler
        const themeButtons = document.querySelectorAll('[data-bs-theme-value]');
        themeButtons.forEach(button => {
          button.addEventListener('click', () => {
            const theme = button.getAttribute('data-bs-theme-value');
            localStorage.setItem('lte-theme', theme);
            document.documentElement.setAttribute('data-bs-theme', theme);
            document.documentElement.style.colorScheme = theme;

            themeButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            const currentIcon = document.querySelector('#bd-theme-icon');
            if (currentIcon) {
              currentIcon.className = theme === 'dark' 
                ? 'fa-solid fa-moon' 
                : (theme === 'light' ? 'fa-solid fa-sun' : 'fa-solid fa-circle-half-stroke');
            }
          });
        });
      });
    </script>
    <!--end::OverlayScrollbars & Theme Toggle Script-->

    @stack('scripts')
  </body>
  <!--end::Body-->
</html>
