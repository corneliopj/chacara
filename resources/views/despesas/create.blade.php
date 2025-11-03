@extends('layout.master')

@section('title', 'Nova Despesa')

@section('content')
<div class="content">
    <h2>➕ Registrar Nova Despesa</h2>
    
    <form action="{{ route('despesas.store') }}" method="POST">
        @csrf
        
        {{-- Campo de Associação à Cultura --}}
        <div class="form-group">
            <label for="cultura_id">Associar à Cultura (Opcional):</label>
            {{-- $culturas deve ser passado do Controller: Cultura::pluck('nome', 'id') --}}
            <select id="cultura_id" name="cultura_id">
                <option value="">-- Nenhuma Cultura (Despesa Geral) --</option>
                @foreach ($culturas as $id => $nome)
                    <option value="{{ $id }}" {{ old('cultura_id') == $id ? 'selected' : '' }}>
                        {{ $nome }}
                    </option>
                @endforeach
            </select>
            @error('cultura_id') <span class="error-message">{{ $message }}</span> @enderror
        </div>
        
        {{-- Campo Descrição --}}
        <div class="form-group">
            <label for="descricao">Descrição (Ex: Compra de Sementes, Manutenção de Trator):</label>
            <input type="text" id="descricao" name="descricao" required 
                value="{{ old('descricao') }}">
            @error('descricao') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        {{-- Campo Valor --}}
        <div class="form-group">
            <label for="valor">Valor (R$):</label>
            <input type="number" id="valor" name="valor" step="0.01" required 
                value="{{ old('valor') }}">
            @error('valor') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        {{-- Campo Data --}}
        <div class="form-group">
            <label for="data_lancamento">Data do Lançamento:</label>
            <input type="date" id="data_lancamento" name="data_lancamento" required 
                value="{{ old('data_lancamento', date('Y-m-d')) }}">
            @error('data_lancamento') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        {{-- Campo Categoria --}}
        <div class="form-group">
            <label for="categoria">Categoria:</label>
            {{-- As categorias devem ser definidas no Controller ou em um array de constantes --}}
            <select id="categoria" name="categoria" required>
                <option value="">-- Selecione a Categoria --</option>
                @php 
                    $categorias = ['Insumos', 'Mão de Obra', 'Manutenção', 'Combustível', 'Impostos', 'Outros'];
                @endphp
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria }}" {{ old('categoria') == $categoria ? 'selected' : '' }}>
                        {{ $categoria }}
                    </option>
                @endforeach
            </select>
            @error('categoria') <span class="error-message">{{ $message }}</span> @enderror
        </div>

        <div class="flex justify-start gap-4 mt-6">
            <button type="submit" class="btn-primary">Registrar Despesa</button>
            <a href="{{ route('despesas.index') }}" class="btn-secondary">Voltar</a>
        </div>
    </form>
</div>
@endsection