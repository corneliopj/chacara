<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- APLICANDO ESTILOS FLAT ABLE E MELHORANDO O CONTRASTE --}}
    <style>
        /* Cor de destaque principal (Verde) */
        :root {
            --color-primary: #10b981; /* Tailwind green-500 */
            --color-primary-dark: #059669; /* Tailwind green-600 */
        }
        
        /* Botões */
        .btn-primary { @apply px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-150 shadow-md; }
        .btn-secondary { @apply px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition duration-150; }
        
        /* Formulários e Alertas */
        .form-group { @apply mb-4; }
        .form-group label { @apply block text-sm font-medium text-gray-700 mb-1; }
        .form-group input, .form-group select, .form-group textarea { @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 p-2 border; }
        .alert-success { @apply p-3 mb-4 text-sm text-green-700 bg-green-100 border border-green-300 rounded-lg; }
        .error-message { @apply text-xs text-red-500 mt-1 block; }

        /* Estilos Base para Tabelas (Mantidos limpos e com bom contraste) */
        .table-responsive table { @apply w-full border-collapse bg-white shadow-lg rounded-lg; }
        .table-responsive th { @apply px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider bg-gray-50 border-b border-gray-200; }
        .table-responsive td { @apply px-4 py-3 text-sm text-gray-800 border-b border-gray-100; }
        .table-responsive tr:hover { @apply bg-green-50/50; } /* Suavemente verde no hover */
        
        /* Estilo para Títulos dentro do Painel */
        .content h2 { @apply text-2xl font-semibold text-gray-800 mb-6 border-b pb-2; }
        
        /* Botões de Ação na Tabela */
        .btn-icon { @apply p-2 rounded-lg text-white inline-flex items-center justify-center h-8 w-8 text-xs font-semibold shadow-md; }
        
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    
    {{-- 1. NAVBAR SUPERIOR --}}
    {{-- MUDANÇA: Fundo mais limpo e destaque do logo --}}
    <header class="bg-white shadow-lg p-4 flex items-center justify-between sticky top-0 z-20 border-b-4 border-green-500">
        <div class="text-xl font-extrabold text-gray-800 flex items-center">
             <span class="mr-2 text-2xl text-green-500">🌿</span> Chácara Gestão
        </div>
        <nav class="flex space-x-4 text-sm text-gray-600">
            <span class="font-medium text-gray-700">Usuário: Cornelio</span>
        </nav>
    </header>

    {{-- 2. CONTEÚDO PRINCIPAL --}}
    <div class="flex flex-grow">
        
        {{-- 2a. MENU LATERAL ESQUERDO (Sidebar - Estilo Flat Able) --}}
        {{-- MUDANÇA PRINCIPAL: Fundo Cinza Escuro (Sidebar de Alto Contraste) --}}
        <aside class="w-64 bg-gray-900 text-white flex-shrink-0 shadow-2xl h-full sticky top-0">
            <nav class="p-4 space-y-1 text-sm">
                <div class="font-bold text-gray-500 uppercase text-xs pt-2 pb-2 border-b border-gray-700">NAVEGAÇÃO</div>
                
                @php 
                    $currentRoute = Route::currentRouteName();
                    // Item Ativo: Fundo verde e negrito para alto contraste
                    $isActive = fn($route) => $currentRoute === $route ? 'bg-green-500 font-bold shadow-lg' : 'hover:bg-gray-700';
                @endphp

                <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('dashboard') }}">
                    <span class="mr-3 text-lg">📊</span> Dashboard
                </a>

                <div class="font-bold text-gray-500 uppercase text-xs pt-4 pb-2 border-b border-gray-700">MÓDULOS DE DADOS</div>
                
                <a href="{{ route('culturas.index') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('culturas.index') }}">
                    <span class="mr-3 text-lg">🌱</span> Culturas
                </a>
                
                <a href="{{ route('despesas.index') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('despesas.index') }}">
                    <span class="mr-3">💸</span> Despesas
                </a>
                
                <a href="{{ route('receitas.index') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('receitas.index') }}">
                    <span class="mr-3">💰</span> Receitas
                </a>
                
                <a href="{{ route('tarefas.index') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('tarefas.index') }}">
                    <span class="mr-3">📋</span> Tarefas
                </a>

                <div class="font-bold text-gray-500 uppercase text-xs pt-4 pb-2 border-b border-gray-700">ANÁLISE</div>

                <a href="{{ route('relatorios.financeiro_cultura') }}" class="flex items-center p-3 rounded-lg transition duration-150 {{ $isActive('relatorios.financeiro_cultura') }}">
                    <span class="mr-3">📈</span> Balanço/Cultura
                </a>
            </nav>
        </aside>

        {{-- 2b. PAINEL PRINCIPAL (Content Area) --}}
        <main class="flex-grow p-8">
            <div class="content bg-white shadow-xl rounded-lg p-6 min-h-full">
                @yield('content') 
            </div>
        </main>
    </div>

    {{-- 3. RODAPÉ --}}
    <footer class="bg-gray-800 text-center p-3 text-gray-400 text-sm border-t mt-auto">
        &copy; {{ date('Y') }} Chácara Gestão. Todos os direitos reservados.
    </footer>
    
    @stack('scripts')
</body>
</html>