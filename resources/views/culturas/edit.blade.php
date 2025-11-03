@extends('layout.master')

@section('title', 'Editar Cultura: ' . $cultura->nome)

@section('content')
<div class="content">
    <h2>✏️ Editar Cultura: {{ $cultura->nome }}</h2>
    
    <form action="{{ route('culturas.update', $cultura) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nome">Nome da Cultura:</label>
            <input type="text" id="nome" name="nome" required 
                value="{{ old('nome', $cultura->nome) }}">
            @error('nome') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="area_ha">Área (em hectares - ha):</label>
            <input type="number" id="area_ha" name="area_ha" step="0.01" required 
                value="{{ old('area_ha', $cultura->area_ha) }}">
            @error('area_ha') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="data_plantio">Data de Plantio:</label>
            <input type="date" id="data_plantio" name="data_plantio" required 
                value="{{ old('data_plantio', $cultura->data_plantio->format('Y-m-d')) }}">
            @error('data_plantio') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="data_colheita_prevista">Colheita Prevista (Opcional):</label>
            <input type="date" id="data_colheita_prevista" name="data_colheita_prevista" 
                value="{{ old('data_colheita_prevista', $cultura->data_colheita_prevista ? $cultura->data_colheita_prevista->format('Y-m-d') : '') }}">
            @error('data_colheita_prevista') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                @php $statuses = ['Ativa', 'Inativa', 'Colheita']; @endphp
                @foreach ($statuses as $s)
                    <option value="{{ $s }}" {{ old('status', $cultura->status) == $s ? 'selected' : '' }}>
                        {{ $s }}
                    </option>
                @endforeach
            </select>
            @error('status') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes">{{ old('observacoes', $cultura->observacoes) }}</textarea>
            @error('observacoes') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <button type="submit" class="btn-primary">Atualizar Cultura</button>
            <a href="{{ route('culturas.index') }}" class="btn-secondary">Voltar</a>
        </div>
    </form>
</div>
@endsection