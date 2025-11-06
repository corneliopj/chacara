@extends('layout.master')

@section('title', 'Editar Despesa: ' . $despesa->descricao)
@section('title_page', 'Edição de Despesa')

@section('content')
@php
    use Carbon\Carbon;
@endphp
<div class="row">
    <div class="col-md-8">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title">✏️ Editar Despesa: {{ $despesa->descricao }}</h3>
            </div>
            
            <form action="{{ route('despesas.update', $despesa) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                
                    {{-- Estrutura em duas colunas --}}
                    <div class="row">
                        {{-- 1. Data do Gasto --}}
                        <div class="form-group col-md-6">
                            <label for="data">Data do Gasto:</label>
                            <input type="date" id="data" name="data" class="form-control @error('data') is-invalid @enderror" required 
                                value="{{ old('data', Carbon::parse($despesa->data)->format('Y-m-d')) }}"> 
                            @error('data')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 2. Valor --}}
                        <div class="form-group col-md-6">
                            <label for="valor">Valor (R$):</label>
                            <input type="number" step="0.01" id="valor" name="valor" class="form-control @error('valor') is-invalid @enderror" required 
                                value="{{ old('valor', $despesa->valor) }}" min="0.01">
                            @error('valor')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- 3. Categoria --}}
                        <div class="form-group col-md-6">
                            <label for="categoria">Categoria:</label>
                            <select id="categoria" name="categoria" class="form-control @error('categoria') is-invalid @enderror" required>
                                <option value="">-- Selecione a Categoria --</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria }}" 
                                        {{ old('categoria', $despesa->categoria) == $categoria ? 'selected' : '' }}>
                                        {{ $categoria }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        {{-- 4. Associação à Cultura --}}
                        <div class="form-group col-md-6">
                            <label for="cultura_id">Associar à Cultura (Opcional):</label>
                            <select id="cultura_id" name="cultura_id" class="form-control @error('cultura_id') is-invalid @enderror">
                                <option value="">-- Nenhuma Cultura (Despesa Geral) --</option>
                                @foreach ($culturas as $cultura)
                                    <option value="{{ $cultura->id }}" 
                                        {{ old('cultura_id', $despesa->cultura_id) == $cultura->id ? 'selected' : '' }}>
                                        {{ $cultura->nome }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cultura_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- 5. Descrição (Linha Inteira) --}}
                    <div class="form-group">
                        <label for="descricao">Descrição:</label>
                        <input type="text" id="descricao" name="descricao" class="form-control @error('descricao') is-invalid @enderror" required 
                            value="{{ old('descricao', $despesa->descricao) }}">
                        @error('descricao')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- 6. Observações (Linha Inteira) --}}
                    <div class="form-group">
                        <label for="observacoes">Observações (Opcional):</label>
                        <textarea id="observacoes" name="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="2">{{ old('observacoes', $despesa->observacoes) }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-danger"><i class="fas fa-save mr-1"></i> Atualizar Despesa</button>
                    <a href="{{ route('despesas.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-times-circle mr-1"></i> Voltar</a>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="callout callout-info mt-4">
            <h5>Informação!</h5>
            <p>
                A alteração de categorias ou vinculação de culturas será refletida imediatamente nos custos gerais e específicos.
            </p>
        </div>
    </div>
</div>
@endsection