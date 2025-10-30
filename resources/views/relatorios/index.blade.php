<?php $__env->startSection('content'); ?>
<div class="content">
    <h2>📋 Relatórios Financeiros</h2>

    <form action="/relatorios" method="POST" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ccc; border-radius: 5px; background: #f9f9f9;">
        <input type="hidden" name="_token" value="SIMULATED_TOKEN">
        
        <label for="data_inicio">Data Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" value="<?php echo $filtros['data_inicio'] ?? date('Y-m-01'); ?>" required>

        <label for="data_fim">Data Fim:</label>
        <input type="date" id="data_fim" name="data_fim" value="<?php echo $filtros['data_fim'] ?? date('Y-m-d'); ?>" required>
        
        <label for="cultura_id">Filtrar Cultura (Opcional):</label>
        <select id="cultura_id" name="cultura_id">
            <option value="">Todas as Culturas</option>
            <?php foreach ($culturas as $cultura): ?>
                <option value="<?php echo $cultura->id; ?>" <?php echo (isset($filtros['cultura_id']) && $filtros['cultura_id'] == $cultura->id) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cultura->nome); ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" class="btn">Gerar Relatório</button>
    </form>

    <?php if ($resultados): ?>
    <h3>Resultados do Relatório</h3>
    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Item</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>Total Receitas</td><td style="color: green;">R$ <?php echo number_format($resultados['total_receitas'], 2, ',', '.'); ?></td></tr>
            <tr><td>Total Despesas</td><td style="color: red;">R$ <?php echo number_format($resultados['total_despesas'], 2, ',', '.'); ?></td></tr>
            <tr><td>**Lucro/Prejuízo (Receitas - Despesas)**</td><td>**R$ <?php echo number_format($resultados['lucro'], 2, ',', '.'); ?>**</td></tr>
            <?php if (isset($resultados['custo_ha'])): ?>
            <tr><td>Cultura Analisada</td><td><?php echo htmlspecialchars($resultados['cultura_nome']); ?> (<?php echo $resultados['area']; ?> ha)</td></tr>
            <tr><td>**Custo por Hectare (Custo / Área)**</td><td>**R$ <?php echo number_format($resultados['custo_ha'], 2, ',', '.'); ?> / ha**</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>