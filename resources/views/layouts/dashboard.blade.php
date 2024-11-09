<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>I-DARF</title>
</head>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-nav">

        <a class="navbar-brand ps-3" href="{{ route('dashboard.index') }}">I-DARF</a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>

        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></form>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-user-gear"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a>
                    </li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('login.destroy') }}">Sair</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-five" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">

                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'dashboard']) href="{{
                            route('dashboard.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'transactions', ]) href="{{
                            route('transactions.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-list"></i>
                            </div>
                            Transações
                        </a>
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'taxes', ]) href="{{
                            route('taxes.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-barcode"></i>
                            </div>
                            Impostos
                        </a>
                        <hr>
                        <span class="sb-sidenav-menu-heading">Administrador</span>
                        @can('index-ticker')
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'tickers']) href="{{
                            route('tickers.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-regular fa-star"></i>
                            </div>
                            Tickers
                        </a>
                        @endcan

                        @can('index-rule')
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'rules']) href="{{
                            route('rules.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-regular fa-clipboard"></i>
                            </div>
                            Regras
                        </a>
                        @endcan

                        @can('index-user')
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'users']) href="{{
                            route('user.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            Usuários
                        </a>
                        @endcan

                        @can('index-role')
                        <a @class(['nav-link', 'active'=> isset($menu) && $menu == 'roles']) href="{{
                            route('role.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            Hierarquia
                        </a>
                        @endcan

                        @can('index-permission')
                        <a @class([ 'nav-link' , 'active'=> isset($menu) && $menu == 'permissions',
                            ]) class="nav-link" href="{{ route('permission.index') }}">
                            <div class="sb-nav-link-icon">
                                <i class="fa-solid fa-user-shield"></i>
                            </div>
                            Permissões
                        </a>
                        @endcan

                        {{-- <a class="nav-link" href="{{ route('login.destroy') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-arrow-right-from-bracket"></i></div>
                            Sair
                        </a> --}}
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logado:
                        @if (auth()->check())
                        {{ auth()->user()->name }}
                        @endif
                    </div>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">

            <main>
                @yield('content')
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; I-DARF {{ date('Y') }}</div>
                    </div>
                </div>
            </footer>

        </div>

    </div>

</body>

</html>