<?php
// routes/web.php - Definição das Rotas

// Formato: ['method' => 'GET/POST', 'uri' => 'caminho', 'controller' => 'NomeController', 'action' => 'metodo']
$routes = [
    // Dashboard e API
    ['method' => 'GET', 'uri' => '', 'controller' => 'DashboardController', 'action' => 'index'],
    ['method' => 'GET', 'uri' => 'dashboard', 'controller' => 'DashboardController', 'action' => 'index'],
    ['method' => 'GET', 'uri' => 'api/graficos', 'controller' => 'DashboardController', 'action' => 'apiGraficos'],
    
    // Culturas CRUD
    ['method' => 'GET', 'uri' => 'culturas', 'controller' => 'CulturaController', 'action' => 'index'],
    ['method' => 'GET', 'uri' => 'culturas/criar', 'controller' => 'CulturaController', 'action' => 'criar'],
    ['method' => 'POST', 'uri' => 'culturas', 'controller' => 'CulturaController', 'action' => 'salvar'],
    // ... (rotas de edição/atualização/deleção omitidas por brevidade, mas devem seguir o padrão)

    // Despesas CRUD
    ['method' => 'GET', 'uri' => 'despesas', 'controller' => 'DespesaController', 'action' => 'index'],
    ['method' => 'POST', 'uri' => 'despesas', 'controller' => 'DespesaController', 'action' => 'salvar'],

    // Receitas CRUD
    ['method' => 'GET', 'uri' => 'receitas', 'controller' => 'ReceitaController', 'action' => 'index'],
    ['method' => 'POST', 'uri' => 'receitas', 'controller' => 'ReceitaController', 'action' => 'salvar'],
    
    // Inventário CRUD
    ['method' => 'GET', 'uri' => 'inventario', 'controller' => 'InventarioController', 'action' => 'index'],
    ['method' => 'POST', 'uri' => 'inventario', 'controller' => 'InventarioController', 'action' => 'salvar'],

    // Tarefas CRUD
    ['method' => 'GET', 'uri' => 'tarefas', 'controller' => 'TarefaController', 'action' => 'index'],
    ['method' => 'POST', 'uri' => 'tarefas', 'controller' => 'TarefaController', 'action' => 'salvar'],

    // Relatórios
    ['method' => 'GET', 'uri' => 'relatorios', 'controller' => 'RelatoriosController', 'action' => 'index'],
    ['method' => 'POST', 'uri' => 'relatorios', 'controller' => 'RelatoriosController', 'action' => 'gerar'],
];