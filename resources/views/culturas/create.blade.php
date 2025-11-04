@extends('layout.master')

@section('title', 'Nova Cultura')
@section('title_page', 'Cadastro de Cultura')

@section('content')

<div class="row">
    <div class="col-md-8">
        {{-- Card AdminLTE com cor primária (azul escuro/padrão) --}}
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Registrar Nova Cultura</h3>
            </div>
            
            {{-- Início do Formulário --}}
            {{-- O action aponta para o método store do CulturaController --}}
            <form action="{{ route('culturas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    {{-- 1. Nome da Cultura --}}
                    <div class="form-group">
                        <label for="nome">Nome da Cultura</label>
                        <input type="text" 
                               class="form-control @error('nome') is-invalid @enderror" 
                               id="nome" 
                               name="nome" 
                               value="{{ old('nome') }}" 
                               placeholder="Ex: Milho, Soja, Arroz" 
                               required>
                        @error('nome')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    {{-- 2. Estoque Mínimo (Referente ao Inventário) --}}
                    <div class="form-group">
                        <label for="estoque_minimo">Estoque Mínimo (Unidades)</label>
                        <input type="number" 
                               class="form-control @error('estoque_minimo') is-invalid @enderror" 
                               id="estoque_minimo" 
                               name="estoque_minimo" 
                               value="{{ old('estoque_minimo', 0) }}" 
                               placeholder="Ex: 100" 
                               min="0">
                        <small class="form-text text-muted">Aviso de estoque será gerado se a quantidade cair abaixo deste valor.</small>
                        @error('estoque_minimo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    {{-- 3. Data de Plantio --}}
                    {{-- Campos de datas e observações foram removidos do Controller inicial para simplificar. 
                         Se precisar deles, atualizaremos o Modelo e o Controller. Por enquanto, focaremos nos campos essenciais: nome e estoque. --}}
                    
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
            {{-- Fim do Formulário --}}

        </div>
    </div>
    
    {{-- Coluna vazia para alinhar o card --}}
    <div class="col-md-4"></div>
</div>

@endsection