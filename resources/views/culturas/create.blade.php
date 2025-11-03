@extends('layout.master')

@section('title', 'Nova Cultura')

@section('content')
<div class="content">
    <h2>➕ Registrar Nova Cultura</h2>
    
    <form action="{{ route('culturas.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="nome">Nome da Cultura:</label>
            <input type="text" id="nome" name="nome" required value="{{ old('nome') }}">
            @error('nome') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="area_ha">Área (em hectares - ha):</label>
            <input type="number" id="area_ha" name="area_ha" step="0.01" required value="{{ old('area_ha') }}">
            @error('area_ha') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="data_plantio">Data de Plantio:</label>
            <input type="date" id="data_plantio" name="data_plantio" required value="{{ old('data_plantio', date('Y-m-d')) }}">
            @error('data_plantio') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="data_colheita_prevista">Colheita Prevista (Opcional):</label>
            <input type="date" id="data_colheita_prevista" name="data_colheita_prevista" value="{{ old('data_colheita_prevista') }}">
            @error('data_colheita_prevista') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status Inicial:</label>
            <select id="status" name="status" required>
                <option value="Ativa" {{ old('status') == 'Ativa' ? 'selected' : '' }}>Ativa</option>
                <option value="Inativa" {{ old('status') == 'Inativa' ? 'selected' : '' }}>Inativa</option>
                <option value="Colheita" {{ old('status') == 'Colheita' ? 'selected' : '' }}>Em Colheita</option>
            </select>
            @error('status') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="observacoes">Observações (Solo, Cultivar, etc.):</label>
            <textarea id="observacoes" name="observacoes">{{ old('observacoes') }}</textarea>
            @error('observacoes') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <button type="submit" class="btn-primary">Salvar Cultura</button>
            <a href="{{ route('culturas.index') }}" class="btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection