@extends('layout.master')

@section('title', 'Nova Despesa')
@section('title_page', 'Registro de Despesa (Geral ou Vinculada)')

@section('content')

<div class="row">
    <div class="col-md-7">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-minus-circle mr-1"></i> Registrar Novo Gasto</h3>
            </div>
            
            <form action="{{ route('despesas.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    
                    {{-- Mensagens de erro de validação --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5><i class="icon fas fa-ban"></i> Erro de Validação!</h5>
                            Verifique os campos abaixo.
                        </div>
                    @endif

                    {{-- PRIMEIRA LINHA: Data e Valor --}}
                    <div class="row">
                        {{-- Data do Gasto --}}
                        <div class="form-group col-md-6">
                            <label for="data">Data do Gasto</label>
                            <input type="date" class="form-control @error('data') is-invalid @enderror" id="data" name="data" value="{{ old('data', now()->format('Y-m-d')) }}" required>
                            @error('data')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Valor da Despesa --}}
                        <div class="form-group col-md-6">
                            <label for="valor">Valor (R$)</label>
                            <input type="number" step="0.01" class="form-control @error('valor') is-invalid @enderror" id="valor" name="valor" value="{{ old('valor') }}" required min="0.01">
                            @error('valor')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                    </div>
                    
                    {{-- SEGUNDA LINHA: Categoria e Vincular à Cultura --}}
                    <div class="row">
                         {{-- Categoria --}}
                         <div class="form-group col-md-6">
                            <label for="categoria">Categoria</label>
                            <select class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                                <option value="">-- Selecione a Categoria --</option>
                                {{-- $categorias deve ser carregado do controller --}}
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat }}" {{ old('categoria') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('categoria')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        {{-- Vincular à Cultura --}}
                        <div class="form-group col-md-6">
                            <label for="cultura_id">Vincular à Cultura (Opcional)</label>
                            <select class="form-control @error('cultura_id') is-invalid @enderror" id="cultura_id" name="cultura_id">
                                <option value="">-- Despesa Geral --</option>
                                @foreach ($culturas as $cultura)
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
                    
                    {{-- Descrição (Linha Inteira) --}}
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <input type="text" class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao" value="{{ old('descricao') }}" required>
                        @error('descricao')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="pago_por_socio_id">Pago por:</label>
                         {{-- $socios deve ser carregado no Controller --}}
                            <select class="form-control" name="pago_por_socio_id" id="pago_por_socio_id" required>
                                 <option value="">-- Selecione o Sócio --</option>
                                     @foreach ($socios as $socio)
                                         <option value="{{ $socio->id }}">{{ $socio->nome }}</option>
                                     @endforeach
                            </select>
                     </div>
                    
                    {{-- Observações (Linha Inteira) --}}
                    <div class="form-group">
                        <label for="observacoes">Observações (Opcional)</label>
                        <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes" rows="2">{{ old('observacoes') }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                </div>
                
                <div class="card-footer">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-save mr-1"></i> Salvar Despesa
                    </button>
                    <a href="{{ route('despesas.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-times-circle mr-1"></i> Cancelar
                    </a>
                </div>
            </form>

        </div>
    </div>
    <div class="col-md-5">
        <div class="callout callout-info mt-4">
            <h5>Sobre Despesas!</h5>
            <p>
                Despesas **diretas** (sementes, insumos específicos) devem ser registradas na tela de **Edição da Cultura**.
            </p>
            <p>
                Use este formulário para despesas **gerais** (combustível, eletricidade, equipamentos) que são compartilhadas por várias culturas e não devem ser contabilizadas no custeio direto de uma única cultura. Para estas, deixe o campo "Vincular à Cultura" como **Despesa Geral**.
            </p>
        </div>
    </div>
</div>

@endsection