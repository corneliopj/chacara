<?php $__env->startSection('content'); ?>
<div class="content" style="text-align: center; color: #f44336;">
    <h2>🚫 Erro 404: Página Não Encontrada</h2>
    <p>A URL que você tentou acessar não existe no sistema da Fazenda Digital.</p>
    <a href="/dashboard" class="btn" style="background-color: #f44336;">Voltar ao Dashboard</a>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>