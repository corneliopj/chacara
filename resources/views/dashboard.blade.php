@extends('layout.master')

@section('title', 'Dashboard - Resumo Financeiro')

@section('content')

    <div class="row">
        <div class="col-lg-3 col-6">
            {{-- Card Receitas --}}
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>R$ {{ number_format($total_receitas, 2, ',', '.') }}</h3>
                    <p>Receitas Totais</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('receitas.index') }}" class="small-box-footer">
                    Detalhes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            {{-- Card Despesas (Gastos) --}}
            <div class="small-box bg-danger">
                <div class="inner">
                    {{-- CORREÇÃO: Usando $total_despesas em vez de $total_gastos --}}
                    <h3>R$ {{ number_format($total_despesas, 2, ',', '.') }}</h3> 
                    <p>Despesas (Gastos) Totais</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave-alt"></i>
                </div>
                <a href="{{ route('despesas.index') }}" class="small-box-footer">
                    Detalhes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            {{-- Card Balanço/Lucro --}}
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>R$ {{ number_format($balanco_geral, 2, ',', '.') }}</h3> 
                    <p>Balanço (Lucro/Prejuízo)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-balance-scale"></i>
                </div>
                <a href="{{ route('relatorios.financeiro_cultura') }}" class="small-box-footer">
                    Relatório <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            {{-- Card Culturas --}}
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ \App\Models\Cultura::count() }}</h3> 
                    <p>Culturas Ativas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <a href="{{ route('culturas.index') }}" class="small-box-footer">
                    Gerenciar <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    {{-- ALERTAS DE ESTOQUE (Card) --}}
    @if($alertas_estoque->isNotEmpty())
    <div class="row">
        <div class="col-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Alertas de Estoque Mínimo</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Quantidade Atual</th>
                                <th>Preço Unitário</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alertas_estoque as $alerta)
                            <tr>
                                <td>{{ $alerta->item }}</td>
                                <td>
                                    <span class="badge badge-danger">{{ $alerta->quantidade }}</span>
                                </td>
                                <td>R$ {{ number_format($alerta->valor_unitario, 2, ',', '.') }}</td>
                                <td>
                                    <a href="#" class="text-muted">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- CULTURAS MAIS CARAS (Card de Exemplo) --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-leaf"></i> 5 Culturas com Maior Despesa</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach($culturas_mais_caras as $cultura_despesa)
                        <li class="item">
                            <div class="product-info">
                                {{ $cultura_despesa->cultura->nome ?? 'Cultura Não Encontrada' }}
                                <span class="product-description float-right text-danger">
                                    R$ {{ number_format($cultura_despesa->total_despesa, 2, ',', '.') }}
                                </span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('despesas.index') }}" class="uppercase">Ver Todas as Despesas</a>
                </div>
            </div>
        </div>
        
        {{-- Adicionar outro Card aqui (ex: Tarefas Recentes) --}}
    </div>

@endsection