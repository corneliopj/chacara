@extends('layout.master')

@section('title', 'Registro de Despesas')

@section('content')
<div class="content">
    <div class="flex justify-between items-center mb-6">
        <h2>💸 Despesas Registradas</h2>
        <a href="{{ route('despesas.create') }}" class="btn-primary">➕ Nova Despesa</a>
    </div>

    @if (session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif
    
    @if ($despesas->isEmpty())
        <p class="text-gray-500">Nenhuma despesa registrada ainda. Comece a lançar seus custos operacionais.</p>
    @else
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Cultura</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Valor (R$)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($despesas as $despesa)
                        <tr class="border-b hover:bg-red-50/50">
                            {{-- Assume que o relacionamento 'cultura' foi carregado com ->with('cultura') no Controller --}}
                            <td>{{ $despesa->cultura->nome ?? 'Geral' }}</td>
                            <td>{{ $despesa->descricao }}</td>
                            <td>{{ $despesa->categoria }}</td>
                            <td>{{ $despesa->data->format('d/m/Y') }}</td>
                            <td class="text-red-600 font-bold">R$ {{ number_format($despesa->valor, 2, ',', '.') }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('despesas.edit', $despesa) }}" class="btn-icon bg-blue-500">✏️</a>
                                
                                <form action="{{ route('despesas.destroy', $despesa) }}" method="POST" onsubmit="return confirm('Confirmar a exclusão desta despesa?');" style="display:inline;">
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