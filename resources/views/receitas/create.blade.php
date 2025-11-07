// resources/views/receitas/create.blade.php

@extends('layout.master')

@section('title', 'Nova Receita')
@section('title_page', 'Registro de Receita de Venda')

@section('content')

<div class="row">
    <div class="col-md-7">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-plus-circle mr-1"></i> Registrar Nova Venda</h3>
            </div>
            
            <form action="{{ route('receitas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-ban"></i> Erro de Validação!</h5>
                            Verifique os campos abaixo.
                        </div>
                    @endif

                    {{-- PRIMEIRA LINHA: Data da Venda e Cultura --}}
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="data_venda">Data da Venda</label>
                            <input type="date" class="form-control @error('data_venda') is-invalid @enderror" id="data_venda" name="data_venda" 
                                value="{{ old('data_venda', now()->format('Y-m-d')) }}" required>
                            @error('data_venda')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                            <div class="form-group col-md-6">
                                    <label for="cultura_id">Cultura de Origem</label>
            <select class="form-control @error('cultura_id') is-invalid @enderror" id="cultura_id" name="cultura_id" required>
                <option value="">-- Selecione a Cultura --</option>
                @foreach ($culturas as $cultura) // <-- O loop está aqui e é o ponto de sucesso
                    <option value="{{ $cultura->id }}" {{ old('cultura_id') == $cultura->id ? 'selected' : '' }}>
                        {{ $cultura->nome }}
                    </option>
                @endforeach
            </select>
            @error('cultura_id')
                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
            @enderror
        </div>
                    </div>
                    
                    {{-- SEGUNDA LINHA: Quantidade, Unidade e Valor Total --}}
                    <div class="row">
                         <div class="form-group col-md-4">
                            <label for="quantidade_vendida">Quantidade Vendida</label>
                            <input type="number" step="0.01" class="form-control @error('quantidade_vendida') is-invalid @enderror" id="quantidade_vendida" name="quantidade_vendida" 
                                value="{{ old('quantidade_vendida') }}" required min="0.01">
                            @error('quantidade_vendida')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="unidade_medida">Unidade de Medida</label>
                            <select class="form-control @error('unidade_medida') is-invalid @enderror" id="unidade_medida" name="unidade_medida" required>
                                <option value="">-- Unidade --</option>
                                @foreach ($unidades as $unidade)
                                    <option value="{{ $unidade }}" {{ old('unidade_medida') == $unidade ? 'selected' : '' }}>{{ $unidade }}</option>
                                @endforeach
                            </select>
                            @error('unidade_medida')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                      <div class="form-group col-md-4">
                            <label for="valor">Valor Total (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" 
                                value="{{ old('valor') }}" required min="0.01">
                            @error('valor')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    
                    {{-- Descrição --}}
                    <div class="form-group">
                        <label for="descricao">Descrição da Venda (Comprador, Local, etc.)</label>
                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" 
                            value="{{ old('descricao') }}" required>
                        @error('descricao')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    {{-- Observações --}}
                    <div class="form-group">
                        <label for="observacoes">Observações (Opcional)</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes" rows="2">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> Salvar Receita
                    </button>
                    <a href="{{ route('receitas.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>
    <div class="col-md-5">
        <div class="callout callout-success mt-4">
            <h5>Sobre Receitas!</h5>
            <p>
                As receitas são essenciais para calcular o lucro líquido da sua propriedade.
            </p>
            <p>
                Certifique-se de associar cada venda à **Cultura** correta para que o resultado financeiro seja apurado de forma precisa.
            </p>
        </div>
    </div>
</div>

@endsection