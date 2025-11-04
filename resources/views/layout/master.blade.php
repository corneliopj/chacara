<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>

    {{-- Google Font: Source Sans Pro (AdminLTE) --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    {{-- Font Awesome (Ícones - AdminLTE Requer) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    {{-- AdminLTE CSS via CDN --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    {{-- Estilos personalizados para sobrescrever ou complementar --}}
    <style>
        /* Ajustes de cor para manter o tema verde, alinhado ao Bootstrap/AdminLTE */
        .bg-success { 
            background-color: #28a745 !important; /* Verde Bootstrap */
        }
        .btn-primary { 
            background-color: #28a745 !important; 
            border-color: #28a745 !important;
        }
        .btn-primary:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
        }
        /* Ajuste do Título Principal */
        .content h2 { 
            font-size: 1.5rem; 
            font-weight: 600;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 0.5rem;
        }
        
        /* Estilos de Card AdminLTE para formulários */
        .card-body .form-group label {
            font-weight: 600;
        }
    </style>
    
    @stack('styles')
</head>

{{-- Classe 'sidebar-mini' é necessária para o layout compacto --}}
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    {{-- 1. NAVBAR SUPERIOR --}}
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
        </ul>
    </nav>
    
    {{-- 2. MENU LATERAL PRINCIPAL (Sidebar) --}}
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        {{-- Logo --}}
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">🌿 Chácara Gestão</span>
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    @php 
                        $currentRoute = Route::currentRouteName();
                        
                        // Usando função anônima tradicional para compatibilidade e evitar erro de Parse
                        $isActive = function($route) use ($currentRoute) {
                            return $currentRoute === $route ? 'active' : '';
                        };
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

                    <li class="nav-header">ANÁLISE</li>

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
        {{-- Header da página com Breadcrumbs (AdminLTE padrão) --}}
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        {{-- CORREÇÃO: Removendo chaves duplas ({{ }}) para evitar ParseError na vírgula. --}}
                        <h1 class="m-0 text-dark">@yield('title_page', @yield('title', 'Dashboard'))</h1>
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
            Sistema de Gestão Agrícola
        </div>
        <strong>Copyright &copy; {{ date('Y') }}</strong>
    </footer>

</div>
{{-- Fim do Wrapper --}}

{{-- SCRIPTS (AdminLTE Requer JQuery e Bootstrap) --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

@stack('scripts')
</body>
</html>