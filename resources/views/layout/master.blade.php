<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- APLICANDO ESTILOS ADMINLTE (Baseado em Tailwind) --}}
    <style>
        /* TONS DE CORES: Sidebar Escura, Destaque Verde/Azul */
        :root {
            --sidebar-bg: #2d3748; /* slate-800 */
            --color-primary: #10b981; /* green-500 */
        }
        
        /* Estilos Globais para Card e Sombra */
        .card-container { @apply bg-white shadow-xl rounded-lg p-6; } /* Estilo principal do AdminLTE */
        
        /* Botões */
        .btn-primary { @apply px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-150 shadow-md; }
        .btn-secondary { @apply px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition duration-150; }
        .btn-icon { @apply p-1 rounded-sm text-white inline-flex items-center justify-center h-7 w-7 text-xs font-semibold shadow-sm; }

        /* Estilos de Formulário */
        .form-group { @apply mb-4; }
        .form-group label { @apply block text-sm font-medium text-gray-700 mb-1; }
        .form-group input, .form-group select, .form-group textarea { @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border; }
        .alert-success { @apply p-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-md; }

        /* Estilos de Tabela (Mais compactos, estilo AdminLTE) */
        .table-responsive table { @apply w-full border-collapse; }
        .table-responsive th { @apply px-4 py-2 text-left text-xs font-bold text-gray-600 uppercase tracking-wider bg-gray-100 border-b border-gray-200; }
        .table-responsive td { @apply px-4 py-2 text-sm text-gray-700 border-b border-gray-100; }
        .table-responsive tr:hover { @apply bg-green-50/50; } 
        
        .content h2 { @apply text-2xl font-semibold text-gray-800 mb-6; }
        
        /* Estilo da Sidebar Ativa */
        .sidebar-active { @apply bg-green-500 text-white font-bold shadow-md; }
        .sidebar-item:hover { @apply bg-slate-700; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    
    {{-- 1. NAVBAR SUPERIOR (Clara e Simples) --}}
    <header class="bg-white shadow-md p-3 flex items-center justify-between sticky top-0 z-20 border-b border-gray-200">
        <div class="text-xl font-bold text-gray-800 flex items-center">
             <span class="mr-2 text-2xl text-green-500">🌿</span> Chácara Gestão
        </div>
        <nav class="flex space-x-4 text-sm text-gray-600">
            <span class="font-medium text-gray-700">Usuário: Cornelio</span>
        </nav>
    </header>

    {{-- 2. CONTEÚDO PRINCIPAL --}}
    <div class="flex flex-grow">
        
        {{-- 2a. MENU LATERAL ESQUERDO (Sidebar - Cinza Escuro Sólido) --}}
        <aside class="w-60 bg-slate-800 text-white flex-shrink-0 shadow-2xl h-full sticky top-0">
            <nav class="p-3 space-y-1 text-sm">
                
                <div class="font-semibold text-gray-400 uppercase text-xs pt-3 pb-1">NAVEGAÇÃO</div>
                
                @php 
                    $currentRoute = Route::currentRouteName();
                    $isActive = fn($route) => $currentRoute === $route ? 'sidebar-active' : 'hover:bg-slate-700';
                @endphp

                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('dashboard') }}">
                    <span class="mr-3 text-base">📊</span> Dashboard
                </a>

                <div class="font-semibold text-gray-400 uppercase text-xs pt-4 pb-1 border-b border-slate-700">MÓDULOS DE DADOS</div>
                
                <a href="{{ route('culturas.index') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('culturas.index') }}">
                    <span class="mr-3 text-base">🌱</span> Culturas
                </a>
                
                <a href="{{ route('despesas.index') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('despesas.index') }}">
                    <span class="mr-3 text-base">💸</span> Despesas
                </a>
                
                <a href="{{ route('receitas.index') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('receitas.index') }}">
                    <span class="mr-3 text-base">💰</span> Receitas
                </a>
                
                <a href="{{ route('tarefas.index') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('tarefas.index') }}">
                    <span class="mr-3 text-base">📋</span> Tarefas
                </a>

                <div class="font-semibold text-gray-400 uppercase text-xs pt-4 pb-1 border-b border-slate-700">ANÁLISE</div>

                <a href="{{ route('relatorios.financeiro_cultura') }}" class="sidebar-item flex items-center p-2 rounded-sm transition duration-150 {{ $isActive('relatorios.financeiro_cultura') }}">
                    <span class="mr-3 text-base">📈</span> Balanço/Cultura
                </a>
            </nav>
        </aside>

        {{-- 2b. PAINEL PRINCIPAL (Content Area) --}}
        <main class="flex-grow p-5">
            {{-- Aplica a classe de Card do AdminLTE --}}
            <div class="content card-container"> 
                @yield('content') 
            </div>
        </main>
    </div>

    {{-- 3. RODAPÉ --}}
    <footer class="bg-white text-center p-3 text-gray-500 text-sm border-t mt-auto">
        <strong class="text-gray-700">Chácara Gestão</strong> &copy; {{ date('Y') }}
    </footer>
    
    @stack('scripts')
</body>
</html>