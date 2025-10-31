@extends('layout.master')

@section('title', 'Dashboard')

@section('content')
<div class="content">
    <h2>📊 Dashboard da Fazenda</h2>

    <div class="grid-3">
        <div class="card bg-green-100 border-green-500">
            <h3>Receitas Totais</h3>
            <p class="text-3xl text-green-700">R$ {{ number_format($total_receitas, 2, ',', '.') }}</p>
        </div>
        <div class="card bg-red-100 border-red-500">
            <h3>Gastos Totais</h3>
            <p class="text-3xl text-red-700">R$ {{ number_format($total_gastos, 2, ',', '.') }}</p>
        </div>
        <div class="card bg-blue-100 border-blue-500">
            <h3>Lucro (Total)</h3>
            <p class="text-3xl text-blue-700">R$ {{ number_format($total_lucro, 2, ',', '.') }}</p>
        </div>
    </div>

    <div class="flex gap-4 mt-5">
        <a href="{{ route('despesas.create') }}" class="btn-primary">➕ Nova Despesa</a>
        <a href="{{ route('receitas.create') }}" class="btn-primary">➕ Nova Receita</a>
        <a href="{{ route('inventario.create') }}" class="btn-primary">➕ Adicionar Inventário</a>
    </div>

    {{-- ALERTA DE ESTOQUE E COLHEITA --}}
    <h3 class="mt-8">⚠️ Alertas</h3>
    @if ($alertas_estoque->isNotEmpty() || $alertas_colheita->isNotEmpty())
        <div class="alert alert-warning">
            @if ($alertas_estoque->isNotEmpty())
                <strong>Estoque Baixo:</strong> 
                @foreach ($alertas_estoque as $alerta)
                    {{ $alerta->item }} ({{ $alerta->quantidade }})@if (!$loop->last), @endif
                @endforeach
            @endif
            @if ($alertas_estoque->isNotEmpty() && $alertas_colheita->isNotEmpty()) | @endif
            @if ($alertas_colheita->isNotEmpty())
                <strong>Colheita Próxima (7 dias):</strong> 
                @foreach ($alertas_colheita as $alerta)
                    {{ $alerta->nome }} ({{ \Carbon\Carbon::parse($alerta->data_colheita_prevista)->format('d/m/Y') }})@if (!$loop->last), @endif
                @endforeach
            @endif
        </div>
    @else
        <p>Nenhum alerta crítico no momento.</p>
    @endif
    
    {{-- TAREFAS PENDENTES --}}
    <h3 class="mt-8">📋 Próximas Tarefas Pendentes</h3>
    <ul class="list-disc ml-5">
        @forelse ($tarefas_pendentes as $tarefa)
            <li>
                {{ \Carbon\Carbon::parse($tarefa->data_prevista)->format('d/m/Y') }} - 
                **{{ $tarefa->tipo }}** em {{ $tarefa->cultura->nome ?? 'Cultura Removida' }}
            </li>
        @empty
            <li>Nenhuma tarefa pendente encontrada.</li>
        @endforelse
    </ul>

    {{-- GRÁFICOS --}}
    <div class="flex justify-between mt-10">
        <div class="w-2/3">
            <h3>Despesas e Receitas Mensais</h3>
            <canvas id="barrasMensais"></canvas>
        </div>
        <div class="w-1/3 ml-4">
            <h3>Lucro por Cultura</h3>
            <canvas id="pizzaLucro"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('{{ route('api.graficos') }}')
            .then(response => response.json())
            .then(data => {
                // GRÁFICO 1: Barras Mensais
                const ctxBarras = document.getElementById('barrasMensais').getContext('2d');
                const meses = data.mensal.map(item => item.mes);
                const despesas = data.mensal.map(item => parseFloat(item.total_despesas));
                const receitas = data.mensal.map(item => parseFloat(item.total_receitas));

                new Chart(ctxBarras, {
                    type: 'bar',
                    data: {
                        labels: meses,
                        datasets: [
                            { label: 'Despesas', data: despesas, backgroundColor: 'rgba(255, 99, 132, 0.5)' },
                            { label: 'Receitas', data: receitas, backgroundColor: 'rgba(75, 192, 192, 0.5)' }
                        ]
                    },
                    options: { scales: { y: { beginAtZero: true } } }
                });

                // GRÁFICO 2: Pizza Lucro por Cultura
                const ctxPizza = document.getElementById('pizzaLucro').getContext('2d');
                const culturas = data.lucro_cultura.map(item => item.nome);
                const lucros = data.lucro_cultura.map(item => parseFloat(item.lucro));

                new Chart(ctxPizza, {
                    type: 'pie',
                    data: {
                        labels: culturas,
                        datasets: [{
                            data: lucros,
                            backgroundColor: lucros.map(() => `hsl(${Math.random() * 360}, 70%, 50%)`),
                        }]
                    }
                });
            });
    });
</script>
@endsection