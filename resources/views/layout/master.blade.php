<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- AQUI ESTÃO OS ESTILOS PARA MELHORAR O CONTRASTE E A APARÊNCIA --}}
    <style>
        /* Botões */
        .btn-primary { @apply px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-150 shadow-md; }
        .btn-secondary { @apply px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-150; }
        
        /* Ícones de Ação (Aumentando o contraste) */
        .btn-icon { @apply p-2 rounded-full text-white inline-flex items-center justify-center h-8 w-8 text-xs font-semibold; }
        .bg-blue-500 { @apply bg-blue-600 hover:bg-blue-700; } /* Edição */
        .bg-red-500 { @apply bg-red-600 hover:bg-red-700; }   /* Exclusão */

        /* Formulários e Alertas (Manutenção do contraste) */
        .form-group { @apply mb-4; }
        .form-group label { @apply block text-sm font-medium text-gray-700 mb-1; }
        .form-group input, .form-group select, .form-group textarea { @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border; }
        
        /* Estilos Base para Tabelas */
        .table-responsive table { @apply w-full border-collapse bg-white shadow-md rounded-lg overflow-hidden; }
        .table-responsive th { @apply px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50 border-b border-gray-200; }
        .table-responsive td { @apply px-4 py-3 whitespace-nowrap text-sm text-gray-800 border-b border-gray-100; }
        .table-responsive tr:hover { @apply bg-gray-50; } /* Adiciona feedback visual ao passar o mouse */
        
        .alert-success { @apply p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg; }
        .error-message { @apply text-xs text-red-500 mt-1 block; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    
    {{-- 1. NAVBAR SUPERIOR --}}
    <header class="bg-white shadow-lg p-4 flex items-center justify-between sticky top-0 z-20">
        <div class="text-xl font-extrabold text-green-700 flex items-center">
             <span class="mr-2 text-2xl">🌿</span> Chácara Gestão
        </div>
        <nav class="flex space-x-4 text-sm text-gray-600">
            <span class="mr-4">Usuário: Cornelio</span>
        </nav>
    </header>

    {{-- 2. CONTEÚDO PRINCIPAL --}}
    <div class="flex flex-grow">
        
        {{-- 2a. MENU LATERAL ESQUERDO (Sidebar) --}}
        {{-- MUDANÇA PRINCIPAL: De bg-green-800 (muito escuro) para bg-green-700 --}}
        <aside class="w-64 bg-green-700 text-white flex-shrink-0 shadow-2xl h-full sticky top-0">
            <nav class="p-4 space-y-1 text-sm">
                <div class="font-bold text-green-300 uppercase text-xs pt-2 pb-2 border-b border-green-600">PRINCIPAL</div>
                
                @php 
                    $currentRoute = Route::currentRouteName();
                    // Usando um fundo verde mais claro e negrito para o item ativo (melhor contraste)
                    $isActive = fn($route) => $currentRoute === $route ? 'bg-green-600 font-bold' : 'hover:bg-green-600';
                @endphp

                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('dashboard') }}">
                    <span class="mr-3">📊</span> Dashboard
                </a>

                <div class="font-bold text-green-300 uppercase text-xs pt-4 pb-2 border-b border-green-600">GESTÃO</div>
                
                <a href="{{ route('culturas.index') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('culturas.index') }}">
                    <span class="mr-3">🌱</span> Culturas
                </a>
                
                <a href="{{ route('despesas.index') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('despesas.index') }}">
                    <span class="mr-3">💸</span> Despesas
                </a>
                
                <a href="{{ route('receitas.index') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('receitas.index') }}">
                    <span class="mr-3">💰</span> Receitas
                </a>
                
                <a href="{{ route('tarefas.index') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('tarefas.index') }}">
                    <span class="mr-3">📋</span> Tarefas
                </a>

                <div class="font-bold text-green-300 uppercase text-xs pt-4 pb-2 border-b border-green-600">RELATÓRIOS</div>

                <a href="{{ route('relatorios.financeiro_cultura') }}" class="flex items-center p-2 rounded-lg transition duration-150 {{ $isActive('relatorios.financeiro_cultura') }}">
                    <span class="mr-3">📈</span> Balanço/Cultura
                </a>
            </nav>
        </aside>

        {{-- 2b. PAINEL PRINCIPAL (Content Area) --}}
        <main class="flex-grow p-8">
            <div class="bg-white shadow-xl rounded-lg p-6 min-h-full">
                {{-- CRÍTICO: O CONTEÚDO DA VIEW FILHA É INJETADO AQUI --}}
                @yield('content') 
            </div>
        </main>
    </div>

    {{-- 3. RODAPÉ --}}
    <footer class="bg-white text-center p-3 text-gray-500 text-sm border-t mt-auto">
        &copy; {{ date('Y') }} Chácara Gestão. Todos os direitos reservados.
    </footer>
    
    @stack('scripts')
</body>
</html>