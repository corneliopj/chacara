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
            {{-- Card Balanço Geral --}}
            <div class="small-box bg-{{ $balanco_geral >= 0 ? 'info' : 'warning' }}">
                <div class="inner">
                    <h3>R$ {{ number_format($balanco_geral, 2, ',', '.') }}</h3>
                    <p>Balanço Geral (Lucro/Prejuízo)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                {{-- Sem link de detalhes aqui, pois é um resumo --}}
                <span class="small-box-footer" style="height: 38px;">&nbsp;</span>
            </div>
        </div>

        @if(isset($alertas_estoque) && $alertas_estoque->isNotEmpty())
        <div class="col-lg-3 col-6">
            {{-- Card Alerta de Estoque --}}
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $alertas_estoque->count() }}</h3>
                    <p>Alertas de Estoque Mínimo</p>
                </div>
                <div class="icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <a href="#" class="small-box-footer">
                    Detalhes <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endif
    </div>

    @if(isset($alertas_estoque) && $alertas_estoque->isNotEmpty())
    {{-- DETALHE DE ALERTAS DE ESTOQUE (Se houver) --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-1"></i> Itens Abaixo do Estoque Mínimo</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th class="text-right">Qtd. Atual</th>
                                <th class="text-right">Valor Unitário</th>
                                <th class="text-right">Valor Total Estimado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alertas_estoque as $alerta)
                                <tr>
                                    <td>{{ $alerta->item }}</td>
                                    <td class="text-right text-danger">{{ number_format($alerta->quantidade, 2, ',', '.') }}</td>
                                    <td class="text-right">R$ {{ number_format($alerta->valor_unitario, 2, ',', '.') }}</td>
                                    <td class="text-right">R$ {{ number_format($alerta->quantidade * $alerta->valor_unitario, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="uppercase">Gerenciar Estoque</a>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    {{-- LINHA PRINCIPAL DE GRÁFICOS E RESUMOS --}}
    <div class="row">

        {{-- CARD NOVO: Resumo de Despesas Pagas por Sócio --}}
        <div class="col-md-6">
            <div class="card card-info card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-money-check-alt mr-1"></i> Despesas Pagas por Sócio</h3>
                </div>
                <div class="card-body p-0">
                    @if ($resumoDespesasSocio->isEmpty())
                        <p class="p-3">Nenhuma despesa registrada com sócio pagador.</p>
                    @else
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Sócio</th>
                                    <th class="text-right">Total Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resumoDespesasSocio as $item)
                                    <tr>
                                        <td>{{ $item['nome'] }}</td>
                                        <td class="text-right">
                                            <span class="text-success font-weight-bold">
                                                R$ {{ number_format($item['total_pago'], 2, ',', '.') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('despesas.index') }}" class="uppercase">Ver Todas as Despesas</a>
                </div>
            </div>
        </div>

        {{-- CULTURAS MAIS CARAS (Card Existente) --}}
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
                                {{ $cultura_despesa->cultura->nome ?? 'Despesas Gerais' }}
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
        
    </div>

@endsection