<?php $__env->startSection('content'); ?>
<div class="content">
    <h2>📊 Dashboard</h2>

    <div class="grid-3">
        <div class="card" style="background-color:#e0ffe0; border-color:#4CAF50;">
            <h3>Receitas Totais</h3>
            <p style="font-size: 1.5em; color: green;">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></p>
        </div>
        <div class="card" style="background-color:#ffe0e0; border-color:#f44336;">
            <h3>Gastos Totais</h3>
            <p style="font-size: 1.5em; color: red;">R$ <?php echo number_format($total_gastos, 2, ',', '.'); ?></p>
        </div>
        <div class="card" style="background-color:#e0e0ff; border-color:#007bff;">
            <h3>Lucro (Total)</h3>
            <p style="font-size: 1.5em; color: blue;">R$ <?php echo number_format($total_lucro, 2, ',', '.'); ?></p>
        </div>
    </div>

    <div style="margin-top: 20px; display: flex; gap: 10px;">
        <a href="/despesas/criar" class="btn">➕ Nova Despesa</a>
        <a href="/receitas/criar" class="btn">➕ Nova Receita</a>
        <a href="/inventario/adicionar" class="btn">➕ Adicionar Inventário</a>
    </div>

    <h3>⚠️ Alertas</h3>
    <?php if (count($alertas_estoque) > 0): ?>
    <div class="alert alert-warning">
        <strong>Estoque Baixo:</strong> 
        <?php foreach ($alertas_estoque as $alerta): ?>
            <?php echo htmlspecialchars($alerta['item']); ?> (<?php echo $alerta['quantidade']; ?>) - 
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <?php if (count($alertas_colheita) > 0): ?>
    <div class="alert alert-warning">
        <strong>Colheita Próxima (7 dias):</strong> 
        <?php foreach ($alertas_colheita as $alerta): ?>
            <?php echo htmlspecialchars($alerta['nome']); ?> (<?php echo date('d/m/Y', strtotime($alerta['data_colheita_prevista'])); ?>) - 
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    
    <h3>📋 Próximas Tarefas</h3>
    <ul>
        <?php foreach ($tarefas_pendentes as $tarefa): ?>
            <li><?php echo date('d/m/Y', strtotime($tarefa['data_prevista'])); ?> - **<?php echo htmlspecialchars($tarefa['tipo']); ?>** em <?php echo htmlspecialchars($tarefa['cultura_nome']); ?></li>
        <?php endforeach; ?>
    </ul>

    <div style="margin-top: 30px; display: flex; justify-content: space-between;">
        <div style="width: 65%;">
            <h3>Despesas e Receitas Mensais</h3>
            <canvas id="barrasMensais"></canvas>
        </div>
        <div style="width: 30%;">
            <h3>Lucro por Cultura</h3>
            <canvas id="pizzaLucro"></canvas>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/graficos')
        .then(response => response.json())
        .then(data => {
            // GRÁFICO 1: Barras Mensais
            const meses = data.mensal.map(item => item.mes);
            const despesas = data.mensal.map(item => item.total_despesas);
            const receitas = data.mensal.map(item => item.total_receitas);

            new Chart(document.getElementById('barrasMensais').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: meses,
                    datasets: [
                        { label: 'Despesas', data: despesas, backgroundColor: 'rgba(255, 99, 132, 0.5)' },
                        { label: 'Receitas', data: receitas, backgroundColor: 'rgba(75, 192, 192, 0.5)' }
                    ]
                },
                options: { scales: { y: { beginAtZero: true } } }
            });

            // GRÁFICO 2: Pizza Lucro por Cultura
            const culturas = data.lucro_cultura.map(item => item.nome);
            const lucros = data.lucro_cultura.map(item => item.lucro);

            new Chart(document.getElementById('pizzaLucro').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: culturas,
                    datasets: [{
                        data: lucros,
                        backgroundColor: culturas.map(() => `hsl(${Math.random() * 360}, 70%, 50%)`),
                    }]
                }
            });
        });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>