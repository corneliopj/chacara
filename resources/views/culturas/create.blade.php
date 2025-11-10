@extends('layout.master')

@section('title', 'Nova Cultura')
@section('title_page', 'Cadastro de Cultura')

@section('content')

<div class="row">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Nova Cultura</h3>
            </div>
            
            <form action="{{ route('culturas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    {{-- 1. Nome da Cultura --}}
                    <div class="form-group">
                        <label for="nome">Nome da Cultura</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" value="{{ old('nome') }}" placeholder="Ex: Milho, Soja, Arroz" required>
                        @error('nome')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    
                    <div class="row">
                        {{-- 2. Área (em metros quadrados) --}}
                        <div class="form-group col-md-4">
                            <label for="area_m2">Área (em m²)</label>
                            <input type="number" step="0.01" class="form-control @error('area_m2') is-invalid @enderror" id="area_m2" name="area_m2" value="{{ old('area_m2') }}" placeholder="Ex: 5500" required>
                            @error('area_m2')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 3. Data de Plantio --}}
                        <div class="form-group col-md-4">
                            <label for="data_plantio">Data de Plantio</label>
                            <input type="date" class="form-control @error('data_plantio') is-invalid @enderror" id="data_plantio" name="data_plantio" value="{{ old('data_plantio', date('Y-m-d')) }}" required>
                            @error('data_plantio')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 4. Colheita Prevista --}}
                        <div class="form-group col-md-4">
                            <label for="colheita_prevista">Colheita Prevista (Opcional)</label>
                            <input type="date" class="form-control @error('colheita_prevista') is-invalid @enderror" id="colheita_prevista" name="colheita_prevista" value="{{ old('colheita_prevista') }}">
                            @error('colheita_prevista')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            **@enderror** {{-- <-- CORRIGIDO AQUI! Antes era </input> --}}
                        </div>
                    </div>

                    <div class="row">
                        {{-- 5. Status Inicial --}}
                        <div class="form-group col-md-4">
                            <label for="status">Status Inicial</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="Ativa" {{ old('status', 'Ativa') == 'Ativa' ? 'selected' : '' }}>Ativa</option>
                                <option value="Plantio Pendente" {{ old('status') == 'Plantio Pendente' ? 'selected' : '' }}>Plantio Pendente</option>
                                <option value="Colheita" {{ old('status') == 'Colheita' ? 'selected' : '' }}>Em Colheita</option>
                                <option value="Finalizada" {{ old('status') == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- 6. Estoque Mínimo --}}
                        <div class="form-group col-md-4">
                            <label for="estoque_minimo">Estoque Mínimo (Unidades)</label>
                            <input type="number" class="form-control @error('estoque_minimo') is-invalid @enderror" id="estoque_minimo" name="estoque_minimo" value="{{ old('estoque_minimo', 0) }}" min="0">
                            <small class="form-text text-muted">Usado para alertas de estoque.</small>
                            @error('estoque_minimo')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>

                    {{-- 7. Observações --}}
                    <div class="form-group">
                        <label for="observacoes">Observações</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes" rows="3">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Salvar Cultura
                    </button>
                    <a href="{{ route('culturas.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>
    <div class="col-md-4"></div>
</div>

@endsection