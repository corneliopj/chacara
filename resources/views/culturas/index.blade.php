@extends('layout.master')

@section('title', 'Gestão de Culturas')

@section('content')
<div class="content">
    <div class="flex justify-between items-center mb-6">
        <h2>🌱 Culturas Cadastradas</h2>
        <a href="{{ route('culturas.create') }}" class="btn-primary">➕ Nova Cultura</a>
    </div>

    @if (session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif
    
    @if ($culturas->isEmpty())
        <p class="text-gray-500">Nenhuma cultura cadastrada ainda. Comece adicionando uma nova cultura!</p>
    @else
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Área (ha)</th>
                        <th>Plantio</th>
                        <th>Previsão Colheita</th>
                        <th>Lucro Acumulado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($culturas as $cultura)
                        <tr>
                            <td>{{ $cultura->nome }}</td>
                            <td>{{ number_format($cultura->area, 2, ',', '.') }} ha</td>
                            <td>{{ \Carbon\Carbon::parse($cultura->data_plantio)->format('d/m/Y') }}</td>
                            <td>
                                @if ($cultura->data_colheita_prevista)
                                    {{ \Carbon\Carbon::parse($cultura->data_colheita_prevista)->format('d/m/Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @php
                                    $lucro = $cultura->receitas_acumuladas - $cultura->gastos_acumulados;
                                @endphp
                                <span class="{{ $lucro >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    R$ {{ number_format($lucro, 2, ',', '.') }}
                                </span>
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('culturas.edit', $cultura) }}" class="btn-icon bg-blue-500">✏️</a>
                                
                                <form action="{{ route('culturas.destroy', $cultura) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover esta cultura? Todas as associações serão afetadas.');" style="display:inline;">
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
@endsection