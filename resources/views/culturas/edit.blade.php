@extends('layout.master')

@section('title', 'Editar Cultura')

@section('content')
<div class="content">
    <h2>✏️ Editar Cultura: {{ $cultura->nome }}</h2>
    
    <form action="{{ route('culturas.update', $cultura) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="nome">Nome da Cultura:</label>
            <input type="text" id="nome" name="nome" required value="{{ old('nome', $cultura->nome) }}">
            @error('nome') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="area">Área (Hectares):</label>
            <input type="number" id="area" name="area" step="0.01" required value="{{ old('area', $cultura->area) }}">
            @error('area') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="data_plantio">Data do Plantio:</label>
            <input type="date" id="data_plantio" name="data_plantio" required value="{{ old('data_plantio', $cultura->data_plantio) }}">
            @error('data_plantio') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="data_colheita_prevista">Colheita Prevista:</label>
            <input type="date" id="data_colheita_prevista" name="data_colheita_prevista" value="{{ old('data_colheita_prevista', $cultura->data_colheita_prevista) }}">
            @error('data_colheita_prevista') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="produtividade_esperada">Produtividade Esperada (por ha):</label>
            <input type="number" id="produtividade_esperada" name="produtividade_esperada" step="0.01" value="{{ old('produtividade_esperada', $cultura->produtividade_esperada) }}">
            @error('produtividade_esperada') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="estoque_minimo">Estoque Mínimo (Unid.):</label>
            <input type="number" id="estoque_minimo" name="estoque_minimo" step="0.01" value="{{ old('estoque_minimo', $cultura->estoque_minimo) }}">
            @error('estoque_minimo') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group mt-4">
            <p>Gastos Acumulados: **R$ {{ number_format($cultura->gastos_acumulados, 2, ',', '.') }}**</p>
            <p>Receitas Acumuladas: **R$ {{ number_format($cultura->receitas_acumuladas, 2, ',', '.') }}**</p>
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <button type="submit" class="btn-primary">Atualizar Cultura</button>
            <a href="{{ route('culturas.index') }}" class="btn-secondary">Voltar</a>
        </div>
    </form>
</div>
@endsection