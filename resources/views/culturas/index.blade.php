@extends('layout.master')

@section('title', 'Gestão de Culturas')

@section('content')
<div class="content">
    <div class="flex justify-between items-center mb-6">
        <h2>🌱 Culturas Registradas</h2>
        <a href="{{ route('culturas.create') }}" class="btn-primary">➕ Nova Cultura</a>
    </div>

    @if (session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif

    @if ($culturas->isEmpty())
        <p class="text-gray-500">Nenhuma cultura registrada ainda. Comece a planejar seu plantio!</p>
    @else
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Área (ha)</th>
                        <th>Plantio</th>
                        <th>Colheita Prevista</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($culturas as $cultura)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="font-semibold">{{ $cultura->nome }}</td>
                            <td>{{ number_format($cultura->area_ha, 2, ',', '.') }}</td>
                            <td>{{ $cultura->data_plantio->format('d/m/Y') }}</td>
                            <td>{{ $cultura->data_colheita_prevista ? $cultura->data_colheita_prevista->format('d/m/Y') : '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($cultura->status) }}">
                                    {{ $cultura->status }}
                                </span>
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('culturas.edit', $cultura) }}" class="btn-icon bg-blue-500">✏️</a>
                                <form action="{{ route('culturas.destroy', $cultura) }}" method="POST" onsubmit="return confirm('Confirmar a exclusão da cultura {{ $cultura->nome }}? Todas as despesas e receitas associadas serão removidas!');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon bg-red-500">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
{{-- Estilos simples para os badges de status --}}
<style>
.status-badge {
    padding: 0.2rem 0.6rem;
    border-radius: 9999px;
    font-size: 0.8em;
    font-weight: bold;
    color: white;
}
.status-ativa { background-color: #10b981; } /* Verde */
.status-inativa { background-color: #6b7280; } /* Cinza */
.status-colheita { background-color: #f59e0b; } /* Amarelo */
</style>
@endsection