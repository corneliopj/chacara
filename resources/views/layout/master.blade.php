<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fazenda App</title>
    <style>
        body { font-family: sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { width: 90%; margin: 20px auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background-color: #4CAF50; color: white; padding: 15px; text-align: center; border-radius: 8px 8px 0 0; }
        .nav a { margin: 0 15px; text-decoration: none; color: white; font-weight: bold; }
        .content { padding: 20px 0; }
        .alert { padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .alert-warning { background-color: #ffc107; color: #333; }
        .btn { background-color: #007bff; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .card { background: #f9f9f9; padding: 15px; border-radius: 5px; text-align: center; border: 1px solid #ddd; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="header">
        <h1>Fazenda Digital</h1>
        <div class="nav">
            <a href="/dashboard">Dashboard</a>
            <a href="/culturas">Culturas</a>
            <a href="/despesas">Despesas</a>
            <a href="/receitas">Receitas</a>
            <a href="/inventario">Inventário</a>
            <a href="/tarefas">Tarefas</a>
            <a href="/relatorios">Relatórios</a>
        </div>
    </div>
    <div class="container">
      <?php 
            // Verifica se a variável que contém o caminho existe e se o arquivo existe
            if (isset($view_content_file) && file_exists($view_content_file)) {
                include $view_content_file; 
            }
        ?>
    </div>
</body>
</html>