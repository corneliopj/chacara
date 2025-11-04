<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    @vite([
        'resources/css/app.css', // Se ainda usa
        'node_modules/admin-lte/dist/css/adminlte.min.css'
    ])
    @stack('styles')
</head>

{{-- Classe 'sidebar-mini' é necessária para o layout compacto --}}
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    {{-- 1. NAVBAR SUPERIOR (AdminLTE Padrão) --}}
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="nav-link">Bem-vindo(a), Cornelio</span>
            </li>
            {{-- Adicione Logout ou outras opções aqui --}}
        </ul>
    </nav>
    
    {{-- 2. MENU LATERAL PRINCIPAL (Sidebar) --}}
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        {{-- Logo (Verde Chácara) --}}
        <a href="{{ route('dashboard') }}" class="brand-link bg-success">
            <span class="brand-text font-weight-light">🌿 Chácara Gestão</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    {{-- Helper para o item ativo AdminLTE --}}
                    @php 
                        $currentRoute = Route::currentRouteName();
                        $isActive = fn($route) => $currentRoute === $route ? 'active' : '';
                        $isMenuOpen = fn($routes) => in_array($currentRoute, $routes) ? 'menu-is-opening menu-open' : '';
                    @endphp

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ $isActive('dashboard') }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">GESTÃO DE DADOS</li>

                    {{-- Culturas --}}
                    <li class="nav-item">
                        <a href="{{ route('culturas.index') }}" class="nav-link {{ $isActive('culturas.index') }}">
                            <i class="nav-icon fas fa-seedling"></i>
                            <p>Culturas</p>
                        </a>
                    </li>

                    {{-- Despesas --}}
                    <li class="nav-item">
                        <a href="{{ route('despesas.index') }}" class="nav-link {{ $isActive('despesas.index') }}">
                            <i class="nav-icon fas fa-money-bill-wave-alt"></i>
                            <p>Despesas</p>
                        </a>
                    </li>

                    {{-- Receitas --}}
                    <li class="nav-item">
                        <a href="{{ route('receitas.index') }}" class="nav-link {{ $isActive('receitas.index') }}">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>Receitas</p>
                        </a>
                    </li>

                    {{-- Tarefas --}}
                    <li class="nav-item">
                        <a href="{{ route('tarefas.index') }}" class="nav-link {{ $isActive('tarefas.index') }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Tarefas</p>
                        </a>
                    </li>

                    <li class="nav-header">RELATÓRIOS</li>

                    {{-- Balanço/Cultura --}}
                    <li class="nav-item">
                        <a href="{{ route('relatorios.financeiro_cultura') }}" class="nav-link {{ $isActive('relatorios.financeiro_cultura') }}">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>Balanço/Cultura</p>
                        </a>
                    </li>
                    
                </ul>
            </nav>
        </div>
    </aside>

    {{-- 3. CONTEÚDO PRINCIPAL --}}
    <div class="content-wrapper">
        {{-- Header da página com Breadcrumbs (Opcional, mas recomendado pelo AdminLTE) --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('title_page', 'Dashboard')</h1>
                    </div>
                </div>
            </div>
        </div>

        {{-- O CONTEÚDO DA VIEW FILHA É INJETADO AQUI --}}
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    
    {{-- 4. RODAPÉ --}}
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Chácara Gestão
        </div>
        <strong>Copyright &copy; {{ date('Y') }}</strong>
    </footer>

</div>
{{-- Fim do Wrapper --}}

{{-- Scripts --}}
{{-- AdminLTE precisa de jQuery e Bootstrap primeiro --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

@vite(['node_modules/admin-lte/dist/js/adminlte.min.js'])

@stack('scripts')
</body>
</html>