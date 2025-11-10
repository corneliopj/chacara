@extends('layout.master')

@section('title', 'Culturas Registradas')
@section('title_page', 'Gestão de Culturas')

@section('content')

@php
    use Carbon\Carbon;
    
    // Supondo que a variável $culturas é um objeto paginado/coleção com os relacionamentos carregados (with(['despesas', 'receitas']) )
    // Se o Controller não carregar os relacionamentos, o código a seguir deve ser otimizado
@endphp

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-seedling mr-1"></i> Culturas Ativas e Finalizadas
                </h3>
                
                {{-- Botão Nova Cultura --}}
                <div class="card-tools">
                    <a href="{{ route('culturas.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus mr-1"></i> Nova Cultura
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                
                {{-- Mensagem de Sucesso (após salvar ou editar) --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($culturas->isEmpty())
                    <div class="alert alert-info m-3">
                        Nenhuma cultura registrada ainda. Use o botão **Nova Cultura** para começar.
                    </div>
                @else
                    <table class="table table-sm table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 25%">Nome da Cultura</th>
                                <th style="width: 10%">Área (m²)</th>
                                <th style="width: 15%">Status</th>
                                <th style="width: 15%" class="text-right">Custeio Total (R$)</th>
                                <th style="width: 15%" class="text-right">Resultado Líquido (R$)</th>
                                <th style="width: 15%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($culturas as $cultura)
                                @php
                                    // Cálculo rápido para exibição na lista
                                    $custeio = $cultura->despesas->sum('valor');
                                    $receita = $cultura->receitas->sum('valor');
                                    $resultado = $receita - $custeio;
                                    
                                    // Define a classe da badge e do resultado
                                    $badge_class = 'secondary';
                                    if ($cultura->status == 'Ativa') $badge_class = 'primary';
                                    if ($cultura->status == 'Em Colheita') $badge_class = 'warning';
                                    if ($cultura->status == 'Finalizada') $badge_class = 'success';
                                    
                                    $resultado_class = $resultado >= 0 ? 'text-success' : 'text-danger';
                                @endphp
                                
                                <tr>
                                    <td>{{ $cultura->id }}</td>
                                    <td>
                                        <b><a href="{{ route('culturas.edit', $cultura->id) }}" title="Ver Detalhes">{{ $cultura->nome }}</a></b>
                                        <p class="text-muted small mb-0">Plantio: {{ Carbon::parse($cultura->data_plantio)->format('d/m/Y') }}</p>
                                    </td>
                                    <td>{{ number_format($cultura->area_m2, 2, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $badge_class }}">{{ $cultura->status }}</span>
                                    </td>
                                    <td class="text-right">
                                        R$ {{ number_format($custeio, 2, ',', '.') }}
                                    </td>
                                    <td class="text-right font-weight-bold {{ $resultado_class }}">
                                        R$ {{ number_format($resultado, 2, ',', '.') }}
                                    </td>
                                    <td>
                                        {{-- Botão Editar --}}
                                        <a href="{{ route('culturas.edit', $cultura->id) }}" class="btn btn-xs btn-info" title="Editar Cultura">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Botão Excluir --}}
                                        <form action="{{ route('culturas.destroy', $cultura->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('ATENÇÃO: Isso excluirá a cultura e todas as receitas/despesas vinculadas. Tem certeza?')" title="Excluir Cultura">
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
            
            {{-- Rodapé do Card com Paginação --}}
            {{-- Assume que $culturas é um objeto paginado --}}
            @if(isset($culturas) && method_exists($culturas, 'lastPage') && $culturas->lastPage() > 1)
                <div class="card-footer clearfix">
                    {{ $culturas->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection