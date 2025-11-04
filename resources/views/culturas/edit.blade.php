@extends('layout.master')

{{-- Usando o nome da cultura para o título da página --}}
@section('title', 'Editar Cultura: ' . $cultura->nome)
@section('title_page', 'Editar Cultura: ' . $cultura->nome)

@section('content')

<div class="row">
    <div class="col-md-8">
        {{-- Card AdminLTE com cor primária --}}
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Detalhes da Cultura</h3>
            </div>
            
            {{-- Início do Formulário --}}
            {{-- Usamos o método POST no HTML, mas o Blade @method('PUT') garante que o Laravel entenda como PUT/PATCH --}}
            <form action="{{ route('culturas.update', $cultura->id) }}" method="POST">
                @csrf
                @method('PUT') 
                
                <div class="card-body">
                    
                    {{-- 1. Nome da Cultura --}}
                    <div class="form-group">
                        <label for="nome">Nome da Cultura</label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome', $cultura->nome) }}" 
                               required>
                        @error('nome')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        {{-- 2. Área (em hectares) --}}
                        <div class="form-group col-md-4">
                            <label for="area">Área (em hectares - ha)</label>
                            <input type="number" step="0.01" 
                                   class="form-control @error('area') is-invalid @enderror" 
                                   id="area" 
                                   name="area" 
                                   value="{{ old('area', $cultura->area) }}" 
                                   required>
                            @error('area')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 3. Data de Plantio --}}
                        <div class="form-group col-md-4">
                            <label for="data_plantio">Data de Plantio</label>
                            <input type="date" 
                                   class="form-control @error('data_plantio') is-invalid @enderror" 
                                   id="data_plantio" 
                                   name="data_plantio" 
                                   value="{{ old('data_plantio', $cultura->data_plantio->format('Y-m-d')) }}" 
                                   required>
                            @error('data_plantio')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 4. Colheita Prevista --}}
                        <div class="form-group col-md-4">
                            <label for="colheita_prevista">Colheita Prevista (Opcional)</label>
                            <input type="date" 
                                   class="form-control @error('colheita_prevista') is-invalid @enderror" 
                                   id="colheita_prevista" 
                                   name="colheita_prevista" 
                                   value="{{ old('colheita_prevista', optional($cultura->colheita_prevista)->format('Y-m-d')) }}">
                            @error('colheita_prevista')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- 5. Status Inicial/Atual --}}
                        <div class="form-group col-md-4">
                            <label for="status">Status</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                @foreach (['Ativa', 'Plantio Pendente', 'Colheita', 'Finalizada'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status', $cultura->status) == $statusOption ? 'selected' : '' }}>
                                        {{ $statusOption }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 6. Estoque Mínimo --}}
                        <div class="form-group col-md-4">
                            <label for="estoque_minimo">Estoque Mínimo (Unidades)</label>
                            <input type="number" 
                                   class="form-control @error('estoque_minimo') is-invalid @enderror" 
                                   id="estoque_minimo" 
                                   name="estoque_minimo" 
                                   value="{{ old('estoque_minimo', $cultura->estoque_minimo ?? 0) }}" 
                                   min="0">
                            @error('estoque_minimo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- 7. Observações --}}
                    <div class="form-group">
                        <label for="observacoes">Observações (Solo, Cultivar, etc.)</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes" rows="3">{{ old('observacoes', $cultura->observacoes) }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-sync-alt mr-1"></i> Atualizar Cultura
                    </button>
                    <a href="{{ route('culturas.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times-circle mr-1"></i> Voltar
                    </a>
                </div>
            </form>

        </div>
    </div>
    <div class="col-md-4"></div>
</div>

@endsection