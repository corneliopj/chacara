<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>
    
    {{-- CRÍTICO: ATIVAR O VITE PARA CARREGAR O TAILWIND/CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    
    {{-- 1. NAVBAR SUPERIOR (Ajuda na localização e navegação) --}}
    <header class="bg-white shadow-md p-4 flex items-center justify-between z-10">
        <div class="text-xl font-bold text-green-700">🌱 Chácara Gestão</div>
        <nav class="flex space-x-4 text-sm text-gray-600">
            {{-- Adicione aqui links de utilidades ou perfil do usuário, se houver --}}
            <span>Usuário: Cornelio</span>
        </nav>
    </header>

    {{-- 2. CONTEÚDO PRINCIPAL (Grid: Sidebar + Main Area) --}}
    <div class="flex flex-grow">
        
        {{-- 2a. MENU LATERAL ESQUERDO (Sidebar) --}}
        <aside class="w-64 bg-green-800 text-white flex-shrink-0 shadow-lg h-full">
            <nav class="p-4 space-y-2">
                <div class="font-semibold text-gray-300 uppercase text-xs pt-4 pb-2 border-b border-green-700">Principal</div>
                
                {{-- Link do Dashboard --}}
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">📊</span> Dashboard
                </a>

                <div class="font-semibold text-gray-300 uppercase text-xs pt-4 pb-2 border-b border-green-700">Gestão</div>
                
                {{-- Link de Culturas --}}
                <a href="{{ route('culturas.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">🌱</span> Culturas
                </a>
                
                {{-- Link de Despesas --}}
                <a href="{{ route('despesas.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">💸</span> Despesas
                </a>
                
                {{-- Link de Receitas --}}
                <a href="{{ route('receitas.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">💰</span> Receitas
                </a>
                
                {{-- Link de Tarefas --}}
                <a href="{{ route('tarefas.index') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">📋</span> Tarefas
                </a>

                <div class="font-semibold text-gray-300 uppercase text-xs pt-4 pb-2 border-b border-green-700">Relatórios</div>

                {{-- Link de Relatórios --}}
                <a href="{{ route('relatorios.financeiro_cultura') }}" class="flex items-center p-2 rounded-lg hover:bg-green-700 transition duration-150">
                    <span class="mr-2">📈</span> Balanço/Cultura
                </a>
            </nav>
        </aside>

        {{-- 2b. PAINEL PRINCIPAL (Content Area) --}}
        <main class="flex-grow p-6 overflow-y-auto">
            {{-- CRÍTICO: O CONTEÚDO DA VIEW FILHA É INJETADO AQUI --}}
            @yield('content') 
        </main>
    </div>

    {{-- 3. RODAPÉ --}}
    <footer class="bg-white text-center p-3 text-gray-500 text-sm border-t mt-auto">
        &copy; {{ date('Y') }} Chácara Gestão. Todos os direitos reservados.
    </footer>
    
    @stack('scripts')
</body>
</html>