@extends('layout.master')

@section('title', 'Despesas Registradas')
@section('title_page', 'Gestão de Despesas')

@section('content')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-money-bill-wave-alt mr-1"></i> Despesas Registradas
                </h3>
                
                <div class="card-tools">
                    <a href="{{ route('despesas.create') }}" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus mr-1"></i> Nova Despesa
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

                @if($despesas->isEmpty())
                    <div class="alert alert-info m-3">
                        Nenhuma despesa registrada ainda. Use o botão **Nova Despesa** para começar.
                    </div>
                @else
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Data</th>
                                <th style="width: 25%">Cultura Vinculada</th>
                                <th style="width: 15%">Categoria</th>
                                <th>Descrição</th>
                                <th style="width: 10%" class="text-right">Valor (R$)</th>
                                <th style="width: 10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($despesas as $despesa)
                                <tr>
                                    {{-- Data Formatada --}}
                                    <td>{{ Carbon::parse($despesa->data)->format('d/m/Y') }}</td> 
                                    
                                    {{-- Cultura Vinculada --}}
                                    <td>
                                        @if ($despesa->cultura)
                                            <a href="{{ route('culturas.edit', $despesa->cultura->id) }}" class="text-info font-weight-bold">
                                                {{ $despesa->cultura->nome }}
                                            </a>
                                        @else
                                            <span class="badge badge-secondary">Geral</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Categoria --}}
                                    <td>{{ $despesa->categoria }}</td>
                                    
                                    {{-- Descrição Truncada --}}
                                    <td title="{{ $despesa->descricao }}">
                                        {{ Str::limit($despesa->descricao, 40) }}
                                    </td>
                                    
                                    {{-- Valor Formatado --}}
                                    <td class="text-right text-danger font-weight-bold">
                                        R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                    </td>
                                    
                                    {{-- Ações --}}
                                    <td>
                                        <a href="{{ route('despesas.edit', $despesa->id) }}" class="btn btn-xs btn-default" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Botão Excluir --}}
                                        <form action="{{ route('despesas.destroy', $despesa->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta despesa?')" title="Excluir">
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
            @if($despesas->lastPage() > 1)
                <div class="card-footer clearfix">
                    {{ $despesas->links() }} 
                </div>
            @endif
        </div>
    </div>
</div>

@endsection