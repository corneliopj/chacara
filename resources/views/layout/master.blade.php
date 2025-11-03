<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chácara Gestão | @yield('title', 'Dashboard')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    @stack('styles')
</head>
<body>
    {{-- Navegação ou Cabeçalho aqui --}}
    <header class="bg-green-700 text-white p-4">
        <nav>
            <a href="{{ route('dashboard') }}" class="mr-4">Dashboard</a>
            <a href="{{ route('culturas.index') }}" class="mr-4">Culturas</a>
            <a href="{{ route('despesas.index') }}" class="mr-4">Despesas</a>
            {{-- Adicionar links Receitas e Tarefas aqui --}}
        </nav>
    </header>

    <main class="container mx-auto p-6">
        @yield('content') 
    </main>

    <footer class="text-center p-4 mt-8 text-gray-600 border-t">
        &copy; {{ date('Y') }} Chácara Gestão
    </footer>
    
    @stack('scripts')
</body>
</html>