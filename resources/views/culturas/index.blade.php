@extends('layout.master')

@section('title', 'Gestão de Culturas')
@section('title_page', 'Culturas Registradas')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-seedling mr-1"></i> Culturas Registradas
                </h3>
                
                <div class="card-tools">
                    <a href="{{ route('culturas.create') }}" class="btn btn-sm btn-success">
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
                        Nenhuma cultura registrada ainda. Comece a planejar seu plantio!
                    </div>
                @else
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Área (ha)</th>
                                <th>Plantio</th>
                                <th>Colheita Prevista</th>
                                <th>Status</th>
                                <th style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($culturas as $cultura)
                                <tr>
                                    <td>{{ $cultura->nome }}</td>
                                    <td>{{ number_format($cultura->area, 2, ',', '.') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cultura->data_plantio)->format('d/m/Y') }}</td>
                                    <td>
                                        @if ($cultura->colheita_prevista)
                                            {{ \Carbon\Carbon::parse($cultura->colheita_prevista)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($cultura->status) {
                                                'Ativa' => 'badge-success',
                                                'Colheita' => 'badge-warning',
                                                'Finalizada' => 'badge-danger',
                                                default => 'badge-secondary',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $cultura->status }}</span>
                                    </td>
                                    <td>
                                        {{-- Botão Editar --}}
                                        <a href="{{ route('culturas.edit', $cultura->id) }}" class="btn btn-xs btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Botão Excluir (Usando formulário para método DELETE) --}}
                                        <form action="{{ route('culturas.destroy', $cultura->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('ATENÇÃO: Isso removerá a cultura e dados financeiros relacionados. Tem certeza que deseja excluir?')" title="Excluir">
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
            @if($culturas->lastPage() > 1)
                <div class="card-footer clearfix">
                    {{ $culturas->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection