@extends('layout.master')

@section('title', 'Editar Cultura: ' . $cultura->nome)
@section('title_page', 'Edição e Detalhes da Cultura')

@section('content')

@php
    // Usamos o Carbon para garantir a formatação correta das datas no HTML
    use Carbon\Carbon;
    $custeio_total = $cultura->despesas->sum('valor');
    // Adicionado para uso no Histórico de Despesas
    $categorias = [
        'Insumo', 'Semente', 'Mão-de-Obra', 'Combustível', 'Eletricidade', 'Equipamento', 'Manutenção', 'Outro Geral'
    ]; 
@endphp

<div class="row">
    {{-- COLUNA ESQUERDA: Informações Principais da Cultura (Detalhes) --}}
    <div class="col-md-6">
        <div class="card card-info card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-info-circle mr-1"></i> Detalhes da Cultura</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('culturas.update', $cultura->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- CAMPOS DE EDIÇÃO DA CULTURA (Estrutura em Colunas) --}}
                    
                    <div class="row">
                        {{-- 1. NOME DA CULTURA --}}
                        <div class="form-group col-md-6">
                            <label for="nome">Nome da Cultura:</label>
                            <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome', $cultura->nome) }}" required>
                            @error('nome')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        {{-- 2. ÁREA --}}
                        <div class="form-group col-md-6">
                            <label for="area_m2">Área (m²):</label>
                            <input type="number" step="0.01" name="area_m2" id="area_m2" class="form-control @error('area_m2') is-invalid @enderror" value="{{ old('area_m2', $cultura->area_m2) }}" required>
                            @error('area_m2')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- 3. DATA DO PLANTIO --}}
                        <div class="form-group col-md-6">
                            <label for="data_plantio">Data do Plantio:</label>
                            <input type="date" name="data_plantio" id="data_plantio" class="form-control @error('data_plantio') is-invalid @enderror" 
                                   value="{{ old('data_plantio', $cultura->data_plantio ? Carbon::parse($cultura->data_plantio)->format('Y-m-d') : '') }}" required>
                            @error('data_plantio')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 4. COLHEITA PREVISTA --}}
                        <div class="form-group col-md-6">
                            <label for="colheita_prevista">Colheita Prevista (Opcional):</label>
                            <input type="date" name="colheita_prevista" id="colheita_prevista" class="form-control @error('colheita_prevista') is-invalid @enderror" 
                                   value="{{ old('colheita_prevista', $cultura->colheita_prevista ? Carbon::parse($cultura->colheita_prevista)->format('Y-m-d') : '') }}">
                            @error('colheita_prevista')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        {{-- 5. STATUS --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status da Cultura:</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="Ativa" {{ old('status', $cultura->status) == 'Ativa' ? 'selected' : '' }}>Ativa</option>
                                <option value="Em Crescimento" {{ old('status', $cultura->status) == 'Em Crescimento' ? 'selected' : '' }}>Em Crescimento</option>
                                <option value="Colheita" {{ old('status', $cultura->status) == 'Colheita' ? 'selected' : '' }}>Em Colheita</option>
                                <option value="Finalizada" {{ old('status', $cultura->status) == 'Finalizada' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- 6. ESTOQUE MÍNIMO --}}
                        <div class="form-group col-md-6">
                            <label for="estoque_minimo">Estoque Mínimo (Kg/unidade):</label>
                            <input type="number" step="0.01" name="estoque_minimo" id="estoque_minimo" class="form-control @error('estoque_minimo') is-invalid @enderror" value="{{ old('estoque_minimo', $cultura->estoque_minimo) }}">
                            @error('estoque_minimo')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- 7. OBSERVAÇÕES (Ocupa a linha inteira) --}}
                    <div class="form-group">
                        <label for="observacoes">Observações:</label>
                        <textarea name="observacoes" id="observacoes" class="form-control @error('observacoes') is-invalid @enderror" rows="3">{{ old('observacoes', $cultura->observacoes) }}</textarea>
                        @error('observacoes')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-info mt-2"><i class="fas fa-save mr-1"></i> Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>
    {{-- FIM DA COLUNA ESQUERDA --}}

    {{-- COLUNA DIREITA: Cadastro Múltiplo de Despesas (O CARRINHO) --}}
    <div class="col-md-6">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-shopping-cart mr-1"></i> Registro Múltiplo de Despesas</h3>
            </div>
            
            <form action="{{ route('despesas.store_multi_cultura') }}" method="POST" id="form-multi-despesas">
                @csrf
                
                {{-- Campo Oculto: Vincula todas as despesas à Cultura atual --}}
                <input type="hidden" name="cultura_id" value="{{ $cultura->id }}">
                
                <div class="card-body">
                    <div class="form-group">
                        <label for="data_base">Data Base para os Gastos:</label>
                        <input type="date" name="data_base" id="data_base" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                        <small class="form-text text-muted">A data abaixo será aplicada a todos os itens adicionados.</small>
                    </div>

                    {{-- Tabela do "Carrinho" de Despesas --}}
                    <table class="table table-sm table-bordered" id="tabela-itens">
                        <thead>
                            <tr>
                                <th style="width: 150px;">Categoria</th>
                                <th>Descrição</th>
                                <th style="width: 120px;">Valor (R$)</th>
                                <th style="width: 50px;">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="lista-despesas">
                            {{-- Itens serão adicionados aqui via jQuery --}}
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right font-weight-bold">TOTAL DO CARRINHO:</td>
                                <td id="total-carrinho" class="font-weight-bold text-danger">R$ 0,00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                   {{-- Formulário de Adição de Item --}}
                    <div class="row mt-3 p-2 border-top border-secondary">
                        <div class="col-4">
                            {{-- REMOVIDO o 'required' para evitar validação nativa ao salvar o carrinho --}}
                            <select id="item-categoria" class="form-control form-control-sm">
                                <option value="">Selecione a Categoria</option>
                                @foreach ($categorias as $categoria)
                                    @if (in_array($categoria, ['Insumo', 'Semente', 'Mão-de-Obra', 'Outro Direto']))
                                        <option value="{{ $categoria }}">{{ $categoria }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            {{-- REMOVIDO o 'required' --}}
                            <input type="text" id="item-descricao" class="form-control form-control-sm" placeholder="Descrição do gasto">
                        </div>
                        <div class="col-2">
                            {{-- REMOVIDO o 'required' --}}
                            <input type="number" step="0.01" id="item-valor" class="form-control form-control-sm" placeholder="Valor" min="0.01">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn-sm btn-success btn-block" id="adicionar-item">
                                <i class="fas fa-cart-plus"></i> Add
                            </button>
                        </div>
                    </div>
                    
                </div>
                
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-danger" id="salvar-carrinho" disabled>
                        <i class="fas fa-save mr-1"></i> Salvar Despesas (<span id="count-carrinho">0</span>)
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- CARD: Listagem de Despesas da Cultura (Existente) --}}
<div class="row">
    <div class="col-12">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-table mr-1"></i> Histórico de Despesas Vinculadas</h3>
                <div class="card-tools">
                    <span class="badge badge-danger">Total Custeio: R$ {{ number_format($custeio_total, 2, ',', '.') }}</span>
                </div>
            </div>
            
            {{-- ADICIONANDO A TABELA DE HISTÓRICO DE DESPESAS --}}
            <div class="card-body p-0">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10%">Data</th>
                            <th style="width: 15%">Categoria</th>
                            <th>Descrição</th>
                            <th style="width: 15%" class="text-right">Valor (R$)</th>
                            <th style="width: 5%">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($cultura->despesas->sortByDesc('data') as $despesa)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($despesa->data)->format('d/m/Y') }}</td>
                                <td>{{ $despesa->categoria }}</td>
                                <td>{{ $despesa->descricao }}</td>
                                <td class="text-right text-danger font-weight-bold">R$ {{ number_format($despesa->valor, 2, ',', '.') }}</td>
                                <td>
                                    {{-- Botões de Ação (Editar e Excluir) --}}
                                    <a href="{{ route('despesas.edit', $despesa->id) }}" class="btn btn-xs btn-default" title="Editar Despesa"><i class="fas fa-edit"></i></a>
                                    
                                    <form action="{{ route('despesas.destroy', $despesa->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta despesa?')" title="Excluir Despesa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nenhuma despesa registrada para esta cultura.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- FIM DA LISTAGEM DE HISTÓRICO --}}
            
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ... (O código JavaScript não foi modificado, pois está correto)

$(document).ready(function() {
    let despesas = [];

    // Função auxiliar para formatar moeda
    function formatCurrency(value) {
        return 'R$ ' + parseFloat(value).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Função principal que redesenha a tabela e atualiza o total
    function updateCart() {
        const $lista = $('#lista-despesas');
        $lista.empty();
        let total = 0;

        despesas.forEach((item, index) => {
            total += item.valor;
            const row = `
                <tr>
                    <td><input type="hidden" name="itens[${index}][categoria]" value="${item.categoria}">${item.categoria}</td>
                    <td><input type="hidden" name="itens[${index}][descricao]" value="${item.descricao}">${item.descricao}</td>
                    <td class="text-danger font-weight-bold"><input type="hidden" name="itens[${index}][valor]" value="${item.valor.toFixed(2)}">${formatCurrency(item.valor)}</td>
                    <td><button type="button" class="btn btn-xs btn-danger remover-item" data-index="${index}"><i class="fas fa-times"></i></button></td>
                </tr>
            `;
            $lista.append(row);
        });

        $('#total-carrinho').text(formatCurrency(total));
        $('#count-carrinho').text(despesas.length);

        // Habilita/Desabilita o botão Salvar
        if (despesas.length > 0) {
            $('#salvar-carrinho').prop('disabled', false);
        } else {
            $('#salvar-carrinho').prop('disabled', true);
        }
    }

    // Ação de Adicionar Item
    $('#adicionar-item').on('click', function(e) {
        e.preventDefault(); 

        const categoria = $('#item-categoria').val();
        const descricao = $('#item-descricao').val();
        const valor = parseFloat($('#item-valor').val().replace(',', '.')) || 0; 

        if (categoria && descricao && valor > 0) {
            despesas.push({
                categoria: categoria,
                descricao: descricao,
                valor: valor
            });

            $('#item-categoria').val('');
            $('#item-descricao').val('');
            $('#item-valor').val('');
            
            updateCart();
        } else {
            alert('Por favor, preencha todos os campos do item corretamente (Categoria, Descrição e Valor > 0).');
        }
    });

    // Ação de Remover Item (usando delegação de evento)
    $('#lista-despesas').on('click', '.remover-item', function() {
        const index = $(this).data('index');
        despesas.splice(index, 1);
        updateCart();
    });

    // Inicialização do carrinho
    updateCart();
});
</script>
@endsection