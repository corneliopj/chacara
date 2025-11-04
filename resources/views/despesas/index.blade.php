@extends('layout.master')

@section('title', 'Despesas Registradas')
@section('title_page', 'Gestão de Despesas')

@section('content')

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
                    <table class="table table-striped table-valign-middle">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Cultura</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Valor (R$)</th>
                                <th style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($despesas as $despesa)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($despesa->data)->format('d/m/Y') }}</td>
                                    <td>
                                        {{-- Exibe o nome da cultura ou 'Geral' se não estiver vinculada --}}
                                        <span class="badge {{ $despesa->cultura_id ? 'badge-primary' : 'badge-secondary' }}">
                                            {{ $despesa->cultura->nome ?? 'Geral' }} 
                                        </span>
                                    </td>
                                    <td>{{ $despesa->categoria }}</td>
                                    <td>{{ Str::limit($despesa->descricao, 50) }}</td> {{-- Limita a descrição para caber na tela --}}
                                    <td>
                                        <span class="text-danger font-weight-bold">
                                            R$ {{ number_format($despesa->valor, 2, ',', '.') }}
                                        </span>
                                    </td>
                                    <td>
                                        {{-- Botão Editar --}}
                                        <a href="{{ route('despesas.edit', $despesa->id) }}" class="btn btn-xs btn-info" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        {{-- Botão Excluir (Usando formulário para método DELETE) --}}
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
                    {{ $despesas->links('vendor.pagination.bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

{{-- Adiciona o uso do Carbon e String Helper --}}
@php
use Illuminate\Support\Str;
@endphp