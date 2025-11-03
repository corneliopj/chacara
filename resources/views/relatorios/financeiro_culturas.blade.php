@extends('layout.master')

@section('title', 'Balanço Financeiro por Cultura')

@section('content')
<div class="content">
    <h2 class="mb-8">💰 Balanço Financeiro por Cultura (Lucro/Prejuízo)</h2>

    <div class="table-responsive">
        <table class="w-full">
            <thead>
                <tr class="text-left bg-gray-100">
                    <th class="py-3 px-4">Cultura / Lançamentos</th>
                    <th class="py-3 px-4">Área (ha)</th>
                    <th class="py-3 px-4">Plantio</th>
                    <th class="py-3 px-4 text-green-700">Receitas (R$)</th>
                    <th class="py-3 px-4 text-red-700">Despesas (R$)</th>
                    <th class="py-3 px-4">Lucro Líquido (R$)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($balanco as $item)
                    <tr class="border-b hover:bg-yellow-50/50">
                        <td class="py-3 px-4 font-semibold">{{ $item['nome'] }}</td>
                        <td class="py-3 px-4">{{ $item['area_ha'] }}</td>
                        <td class="py-3 px-4">{{ $item['data_plantio'] }}</td>
                        <td class="py-3 px-4 text-green-600 font-medium">R$ {{ number_format($item['total_receitas'], 2, ',', '.') }}</td>
                        <td class="py-3 px-4 text-red-600 font-medium">R$ {{ number_format($item['total_despesas'], 2, ',', '.') }}</td>
                        <td class="py-3 px-4 font-bold {{ $item['lucro_liquido'] >= 0 ? 'text-blue-600' : 'text-gray-600' }}">
                            R$ {{ number_format($item['lucro_liquido'], 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach

                {{-- Linha de Lançamentos Gerais --}}
                <tr class="bg-gray-200 border-t-2 border-gray-400">
                    <td class="py-3 px-4 font-bold">{{ $balancoGeral['nome'] }}</td>
                    <td class="py-3 px-4 font-bold">-</td>
                    <td class="py-3 px-4 font-bold">-</td>
                    <td class="py-3 px-4 font-bold text-green-700">R$ {{ number_format($balancoGeral['total_receitas'], 2, ',', '.') }}</td>
                    <td class="py-3 px-4 font-bold text-red-700">R$ {{ number_format($balancoGeral['total_despesas'], 2, ',', '.') }}</td>
                    <td class="py-3 px-4 font-bold {{ $balancoGeral['lucro_liquido'] >= 0 ? 'text-blue-700' : 'text-gray-700' }}">
                        R$ {{ number_format($balancoGeral['lucro_liquido'], 2, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection