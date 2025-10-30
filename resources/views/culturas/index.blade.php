<?php $__env->startSection('content'); ?>
<div class="content">
    <h2>🌱 Culturas Cadastradas</h2>
    <a href="/culturas/criar" class="btn" style="margin-bottom: 15px;">➕ Nova Cultura</a>

    <table border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Área (ha)</th>
                <th>Plantio</th>
                <th>Colheita Prev.</th>
                <th>Prod. Esperada</th>
                <th>Gastos Acum.</th>
                <th>Receitas Acum.</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($culturas as $cultura): ?>
            <tr>
                <td><?php echo htmlspecialchars($cultura->nome); ?></td>
                <td><?php echo number_format($cultura->area, 2, ',', '.'); ?></td>
                <td><?php echo date('d/m/Y', strtotime($cultura->data_plantio)); ?></td>
                <td><?php echo date('d/m/Y', strtotime($cultura->data_colheita_prevista)); ?></td>
                <td><?php echo $cultura->produtividade_esperada; ?></td>
                <td>R$ <?php echo number_format($cultura->gastos_acumulados, 2, ',', '.'); ?></td>
                <td>R$ <?php echo number_format($cultura->receitas_acumuladas, 2, ',', '.'); ?></td>
                <td><a href="/culturas/editar/<?php echo $cultura->id; ?>">Editar</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>