@extends('layout.master')

@section('title', 'Culturas Cadastradas')
@section('title_page', 'Gestão de Culturas')

@section('content')

@php
    use Illuminate\Support\Str;
    // Definição das categorias de despesas (para o resumo do Accordion)
    $despesas_diretas_map = ['Insumo', 'Semente', 'Mão-de-Obra'];
@endphp

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-seedling mr-1"></i> Culturas em Andamento</h3>
                <div class="card-tools">
                    <a href="{{ route('culturas.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Nova Cultura
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success m-3">{{ session('success') }}</div>
                @endif
                
                @if ($culturas->isEmpty())
                    <div class="alert alert-info m-3">Nenhuma cultura cadastrada.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Área (m²)</th>
                                    <th>Plantio</th>
                                    <th class="text-right">Custeio Total (R$)</th>
                                    <th class="text-right">Receita Total (R$)</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($culturas as $cultura)
                                    @php
                                        $custeio = $cultura->despesas_sum_valor ?? 0;
                                        $receita = $cultura->receitas_sum_valor ?? 0; // Quando o Model Receita for implementado
                                        $resultado = $receita - $custeio;
                                        $resultado_classe = $resultado >= 0 ? 'text-success' : 'text-danger';
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="badge badge-success">{{ $cultura->nome }}</span>
                                        </td>
                                        <td>{{ number_format($cultura->area_m2, 2, ',', '.') }}</td>
                                        <td>{{ optional($cultura->data_plantio)->format('d/m/Y') }}</td>
                                        
                                        <td class="text-right text-danger font-weight-bold">
                                            R$ {{ number_format($custeio, 2, ',', '.') }}
                                        </td>
                                        
                                        <td class="text-right text-success font-weight-bold">
                                            R$ {{ number_format($receita, 2, ',', '.') }}
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('culturas.edit', $cultura->id) }}" class="btn btn-xs btn-info" title="Editar / Detalhes">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('culturas.destroy', $cultura->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta cultura?')" title="Excluir">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    
                                    {{-- Linha do Acordion para Detalhes Financeiros --}}
                                    <tr>
                                        <td colspan="6" class="p-0 border-0">
                                            <div class="accordion" id="accordionFinancas{{ $cultura->id }}">
                                                <div class="card card-outline card-secondary mb-0">
                                                    <div class="card-header p-0" id="heading{{ $cultura->id }}">
                                                        <h2 class="mb-0">
                                                            <button class="btn btn-block btn-sm btn-light text-left collapsed rounded-0" type="button" data-toggle="collapse" data-target="#collapse{{ $cultura->id }}" aria-expanded="false" aria-controls="collapse{{ $cultura->id }}">
                                                                <i class="fas fa-chart-line mr-2"></i>
                                                                Resultado Financeiro: 
                                                                <span class="{{ $resultado_classe }} font-weight-bold">
                                                                    R$ {{ number_format($resultado, 2, ',', '.') }}
                                                                </span>
                                                                (Clique para detalhes de custos e receitas)
                                                            </button>
                                                        </h2>
                                                    </div>
                                                    <div id="collapse{{ $cultura->id }}" class="collapse" aria-labelledby="heading{{ $cultura->id }}" data-parent="#accordionFinancas{{ $cultura->id }}">
                                                        <div class="card-body py-2 px-3">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <strong><i class="fas fa-minus-circle text-danger mr-1"></i> Custeio (Despesas):</strong>
                                                                    <ul class="list-unstyled mb-0">
                                                                        {{-- Exibe o total por categoria de despesas diretas --}}
                                                                        @foreach($despesas_diretas_map as $cat)
                                                                            <li>{{ $cat }}: R$ {{ number_format($cultura->despesas->where('categoria', $cat)->sum('valor'), 2, ',', '.') }}</li>
                                                                        @endforeach
                                                                        <li class="font-weight-bold pt-1 border-top mt-1">Total: R$ {{ number_format($custeio, 2, ',', '.') }}</li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong><i class="fas fa-plus-circle text-success mr-1"></i> Receitas (Vendas):</strong>
                                                                    <ul class="list-unstyled mb-0">
                                                                        <li class="font-weight-bold">Total: R$ {{ number_format($receita, 2, ',', '.') }}</li>
                                                                    </ul>
                                                                    <a href="{{ route('culturas.edit', $cultura->id) }}" class="btn btn-xs btn-default float-right mt-2"><i class="fas fa-file-invoice-dollar mr-1"></i> Ver todas despesas</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
            <div class="card-footer clearfix">
                {{ $culturas->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>

@endsection