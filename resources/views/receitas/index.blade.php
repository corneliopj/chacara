// resources/views/receitas/index.blade.php

@extends('layout.master')

@section('title', 'Receitas Registradas')
@section('title_page', 'Gestão de Receitas de Venda')

@section('content')

@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;
@endphp

<div class="row">
    <div class="col-12">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-hand-holding-usd mr-1"></i> Receitas de Venda
                </h3>
                
                <div class="card-tools">
                    <a href="{{ route('receitas.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus mr-1"></i> Nova Receita
                    </a>
                </div>
            </div>
            
            <div class="card-body p-0">
                
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if($receitas->isEmpty())
                    <div class="alert alert-info m-3">
                        Nenhuma receita registrada ainda. Use o botão **Nova Receita** para começar.
                    </div>
                @else
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10%">Data</th>
                                <th style="width: 15%">Cultura</th>
                                <th>Descrição</th>
                                <th style="width: 15%">Quant. / Unidade</th>
                                <th style="width: 12%" class="text-right">Valor Total (R$)</th>
                                <th style="width: 10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receitas as $receita)
                                <tr>
                                    <td>{{ Carbon::parse($receita->data_venda)->format('d/m/Y') }}</td> 
                                    
                                    <td>
                                        <a href="{{ route('culturas.edit', $receita->cultura->id) }}" class="text-info font-weight-bold">
                                            {{ $receita->cultura->nome }}
                                        </a>
                                    </td>
                                    
                                    <td title="{{ $receita->descricao }}">
                                        {{ Str::limit($receita->descricao, 50) }}
                                    </td>

                                    <td>
                                        {{ number_format($receita->quantidade_vendida, 2, ',', '.') }} {{ $receita->unidade_medida }}
                                    </td>
                                    
                                  <td class="text-right text-success font-weight-bold">
                                        R$ {{ number_format($receita->valor, 2, ',', '.') }}
                                    </td>
                                    
                                    <td>
                                        <a href="{{ route('receitas.edit', $receita->id) }}" class="btn btn-xs btn-default" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('receitas.destroy', $receita->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta receita?')" title="Excluir">
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
            
            @if($receitas->lastPage() > 1)
                <div class="card-footer clearfix">
                    {{ $receitas->links() }} 
                </div>
            @endif
        </div>
    </div>
</div>

@endsection