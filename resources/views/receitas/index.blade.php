@extends('layout.master')

@section('title', 'Registro de Receitas')

@section('content')
<div class="content">
    <div class="flex justify-between items-center mb-6">
        <h2>💰 Receitas Registradas</h2>
        <a href="{{ route('receitas.create') }}" class="btn-primary">➕ Nova Receita</a>
    </div>

    @if (session('sucesso'))
        <div class="alert alert-success">{{ session('sucesso') }}</div>
    @endif
    
    @if ($receitas->isEmpty())
        <p class="text-gray-500">Nenhuma receita registrada ainda. Lance suas vendas e outros ganhos.</p>
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
                    @foreach ($receitas as $receita)
                        <tr class="border-b hover:bg-green-50/50">
                            {{-- Assume que o relacionamento 'cultura' foi carregado com ->with('cultura') no Controller --}}
                            <td>{{ $receita->cultura->nome ?? 'Geral' }}</td>
                            <td>{{ $receita->descricao }}</td>
                            <td>{{ $receita->categoria }}</td>
                            <td>{{ $receita->data->format('d/m/Y') }}</td>
                            <td class="text-green-600 font-bold">R$ {{ number_format($receita->valor, 2, ',', '.') }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('receitas.edit', $receita) }}" class="btn-icon bg-blue-500">✏️</a>
                                
                                <form action="{{ route('receitas.destroy', $receita) }}" method="POST" onsubmit="return confirm('Confirmar a exclusão desta receita?');" style="display:inline;">
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