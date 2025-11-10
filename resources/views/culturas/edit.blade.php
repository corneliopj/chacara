@extends('layout.master')

@section('title', 'Editar Cultura: ' . $cultura->nome)
@section('title_page', 'Edição e Detalhes da Cultura')

@section('content')

@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;

    // --- BLOCO DE CÁLCULO E PREPARAÇÃO DE DADOS ---
    
    // 1. CÁLCULO DO RESUMO FINANCEIRO
    $custeio_total = $cultura->despesas->sum('valor');
    $receita_total = $cultura->receitas->sum('valor');
    $resultado_liquido = $receita_total - $custeio_total;

    // 2. CRIAÇÃO DO EXTRATO COMBINADO
    
    // Mapeia Despesas
    $despesas_formatadas = $cultura->despesas->map(function($item) {
        return [
            'data' => $item->data,
            'descricao' => $item->descricao,
            'valor' => $item->valor * -1, // Despesa é valor negativo
            'tipo' => 'Despesa',
            'categoria' => $item->categoria ?? 'N/A',
            'link_edit' => route('despesas.edit', $item->id),
            'link_destroy' => route('despesas.destroy', $item->id),
        ];
    });
    
    // Mapeia Receitas
    $receitas_formatadas = $cultura->receitas->map(function($item) {
        return [
            'data' => $item->data_venda, 
            // Combina quantidade e unidade na descrição para o extrato
            'descricao' => $item->descricao . ' (' . number_format($item->quantidade_vendida, 2, ',', '.') . ' ' . $item->unidade_medida . ')',
            'valor' => $item->valor, // Receita é valor positivo
            'tipo' => 'Receita',
            'categoria' => 'Venda',
            'link_edit' => route('receitas.edit', $item->id),
            'link_destroy' => route('receitas.destroy', $item->id),
        ];
    });

    // Combina e Ordena pela data (mais recente primeiro)
    $extrato = $despesas_formatadas->merge($receitas_formatadas)->sortByDesc('data');

    // Variáveis passadas do Controller
    $unidades = $unidades ?? ['Kg', 'Unidade', 'Saco', 'Litro', 'Caixa'];
    $categorias = $categorias ?? ['Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'];

@endphp

{{-- PRIMEIRA LINHA: DETALHES E RESUMO --}}
<div class="row">
    
    {{-- COLUNA ESQUERDA (6): Detalhes da Cultura (Formulário de Edição) --}}
    <div class="col-md-6">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Detalhes da Cultura</h3>
            </div>
            
            <div class="card-body">
                <form action="{{ route('culturas.update', $cultura->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Campos de Edição da Cultura --}}
                    <div class="form-group">
                        <label for="nome">Nome da Cultura:</label>
                        {{-- ALTERADO: Removido form-control-sm --}}
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $cultura->nome) }}" required>
                        @error('nome')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="area_m2">Área (m²):</label>
                            {{-- ALTERADO: Removido form-control-sm --}}
                            <input type="number" step="0.01" name="area_m2" id="area_m2" class="form-control @error('area_m2') is-invalid @enderror" value="{{ old('area_m2', $cultura->area_m2) }}" required>
                            @error('area_m2')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="status">Status:</label>
                            {{-- ALTERADO: Removido form-control-sm --}}
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                @foreach (['Em Planejamento', 'Ativa', 'Em Colheita', 'Finalizada', 'Cancelada'] as $status)
                                    <option value="{{ $status }}" {{ old('status', $cultura->status) == $status ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="observacoes">Observações (Opcional):</label>
                        {{-- ALTERADO: Removido form-control-sm --}}
                        <textarea name="observacoes" id="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="2">{{ old('observacoes', $cultura->observacoes) }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-info btn-sm mt-2"><i class="fas fa-save mr-1"></i> Salvar Alterações</button>
                    <a href="{{ route('culturas.index') }}" class="btn btn-secondary btn-sm mt-2 ml-2"><i class="fas fa-times-circle mr-1"></i> Voltar</a>
                </form>
            </div>
        </div>
    </div>
    
    {{-- COLUNA DIREITA (6): Resumo Financeiro --}}
    <div class="col-md-6">
        <div class="card card-warning card-outline h-100"> {{-- h-100 para esticar e alinhar --}}
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-chart-line mr-1"></i> Resumo Financeiro da Cultura</h3>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                <div class="row w-100">
                    <div class="col-4 text-center">
                        <h5 class="text-success mb-1">Receita Total</h5>
                        <p class="h4">R$ {{ number_format($receita_total, 2, ',', '.') }}</p>
                    </div>
                    <div class="col-4 text-center">
                        <h5 class="text-danger mb-1">Custeio Total</h5>
                        <p class="h4">R$ {{ number_format($custeio_total, 2, ',', '.') }}</p>
                    </div>
                    <div class="col-4 text-center">
                        <h5 class="{{ $resultado_liquido >= 0 ? 'text-primary' : 'text-danger' }} mb-1">Resultado Líquido</h5>
                        <p class="h4">R$ {{ number_format($resultado_liquido, 2, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SEGUNDA LINHA: FORMULÁRIOS DE LANÇAMENTO --}}
<div class="row">
    
    {{-- COLUNA ESQUERDA (6): Lançar Nova Receita de Venda --}}
    <div class="col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus mr-1"></i> Lançar Nova Receita de Venda</h3>
            </div>
            
            <form action="{{ route('receitas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="cultura_id" value="{{ $cultura->id }}"> 
                
                <div class="card-body">
                    
                    {{-- Data da Venda e Valor --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="data_venda">Data da Venda</label>
                            <input type="date" class="form-control form-control-sm @error('data_venda') is-invalid @enderror" id="data_venda" name="data_venda" value="{{ old('data_venda', now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="valor_receita">Valor Total (R$)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm @error('valor') is-invalid @enderror" id="valor_receita" name="valor" value="{{ old('valor') }}" required min="0.01">
                        </div>
                    </div>

                    {{-- Quantidade e Unidade --}}
                    <div class="row">
                         <div class="form-group col-md-6">
                            <label for="quantidade_vendida">Quantidade</label>
                            <input type="number" step="0.01" class="form-control form-control-sm @error('quantidade_vendida') is-invalid @enderror" id="quantidade_vendida" name="quantidade_vendida" value="{{ old('quantidade_vendida') }}" required min="0.01">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="unidade_medida">Unidade</label>
                            <select class="form-control form-control-sm @error('unidade_medida') is-invalid @enderror" id="unidade_medida" name="unidade_medida" required>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade }}" {{ old('unidade_medida') == $unidade ? 'selected' : '' }}>{{ $unidade }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="form-group">
                        <label for="descricao_receita">Descrição da Venda</label>
                        <input type="text" class="form-control form-control-sm @error('descricao') is-invalid @enderror" id="descricao_receita" name="descricao" value="{{ old('descricao') }}" required>
                    </div>

                </div>
                
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-cash-register mr-1"></i> Registrar Receita
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    {{-- COLUNA DIREITA (6): Lançar Nova Despesa --}}
    <div class="col-md-6">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-minus mr-1"></i> Lançar Nova Despesa</h3>
            </div>
            
            <form action="{{ route('despesas.store') }}" method="POST">
                @csrf
                <input type="hidden" name="cultura_id" value="{{ $cultura->id }}"> 
                
                <div class="card-body">
                    
                    {{-- Data do Gasto e Valor --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="data_despesa">Data do Gasto</label>
                            <input type="date" class="form-control form-control-sm @error('data') is-invalid @enderror" id="data_despesa" name="data" value="{{ old('data', now()->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="valor_despesa">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control form-control-sm @error('valor') is-invalid @enderror" id="valor_despesa" name="valor" value="{{ old('valor') }}" required min="0.01">
                        </div>
                    </div>

                    {{-- Categoria --}}
                    <div class="form-group">
                        <label for="categoria">Categoria</label>
                        <select class="form-control form-control-sm @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            <option value="">-- Selecione a Categoria --</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>{{ $categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Descrição --}}
                    <div class="form-group">
                        <label for="descricao_despesa">Descrição do Gasto</label>
                        <input type="text" class="form-control form-control-sm @error('descricao') is-invalid @enderror" id="descricao_despesa" name="descricao" value="{{ old('descricao') }}" required>
                    </div>
                </div>
                
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-hand-holding-usd mr-1"></i> Registrar Despesa
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- TERCEIRA LINHA: EXTRATO DE LANÇAMENTOS (UNIFICADO) --}}
<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-list-alt mr-1"></i> Extrato de Lançamentos (Despesas e Receitas)</h3>
            </div>
            
            <div class="card-body p-0">
                
                @if($extrato->isEmpty())
                    <div class="alert alert-info m-3">
                        Nenhum lançamento (receita ou despesa) vinculado a esta cultura.
                    </div>
                @else
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Data</th>
                                <th style="width: 15%">Tipo</th>
                                <th style="width: 20%">Categoria/Origem</th>
                                <th>Descrição</th>
                                <th style="width: 15%" class="text-right">Valor (R$)</th>
                                <th style="width: 10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($extrato as $item)
                                <tr>
                                    <td>{{ Carbon::parse($item['data'])->format('d/m/Y') }}</td> 
                                    <td>
                                        <span class="badge badge-{{ $item['tipo'] == 'Receita' ? 'success' : 'danger' }}">{{ $item['tipo'] }}</span>
                                    </td>
                                    <td>{{ $item['categoria'] }}</td>
                                    <td title="{{ strip_tags($item['descricao']) }}">
                                        {{ Str::limit(strip_tags($item['descricao']), 60) }}
                                    </td>
                                    <td class="text-right font-weight-bold text-{{ $item['valor'] >= 0 ? 'success' : 'danger' }}">
                                        R$ {{ number_format(abs($item['valor']), 2, ',', '.') }}
                                    </td>
                                    <td>
                                        <a href="{{ $item['link_edit'] }}" class="btn btn-xs btn-default" title="Editar {{ $item['tipo'] }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ $item['link_destroy'] }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Tem certeza que deseja excluir este lançamento?')" title="Excluir {{ $item['tipo'] }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection