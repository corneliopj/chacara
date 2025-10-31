<?php
// composer_runner.php

// 1. CHAVE DE SEGURANÇA BÁSICA (MUITO IMPORTANTE!)
// Troque 'SUA_CHAVE_SECRETA_UNICA' por uma string complexa e única.
$chave_secreta = '2025'; 

// O script só será executado se o parâmetro 'key' for passado corretamente na URL
if (!isset($_GET['key']) || $_GET['key'] !== $chave_secreta) {
    http_response_code(403);
    die("Acesso Negado. Chave de seguranca invalida ou ausente.");
}

// 2. DEFINE O COMANDO COMPOSER A SER EXECUTADO
// O comando padrão será 'dump-autoload' se nenhum outro for especificado.
$comando = 'dump-autoload'; 

if (isset($_GET['cmd']) && !empty($_GET['cmd'])) {
    // Permite comandos como 'install', 'update', ou 'dump-autoload -o'
    $comando = trim($_GET['cmd']);
}

// 3. MONTA O COMANDO COMPLETO
// Substitua '/usr/bin/php' e '/usr/local/bin/composer' pelos caminhos ABSOLUTOS
// que funcionam no seu ambiente de servidor (se souber, use o caminho do PHP 8.3.6).
$php_path = 'php'; // Tente 'php' primeiro, ou use o caminho completo, ex: '/usr/bin/php8.3'
$composer_path = 'composer'; // Tente 'composer' primeiro, ou use o caminho completo, ex: '/usr/local/bin/composer'

$comando_completo = "{$php_path} {$composer_path} {$comando} 2>&1";

// 4. EXECUTA O COMANDO E CAPTURA A SAÍDA
echo "<pre>Executando: {$comando_completo}\n\n";

// Use shell_exec para executar e capturar toda a saída
$saida = shell_exec($comando_completo);

echo $saida;

echo "\n\n--- FIM DA EXECUCAO ---\n";

// 5. AUTO-DELEÇÃO (RECOMENDADO PARA SEGURANÇA MÁXIMA)
// Descomente as linhas abaixo após testar, para que o arquivo se autodestrua
// para evitar futuros acessos maliciosos.
/*
if (unlink(__FILE__)) {
    echo "\n\nAVISO: O arquivo de execucao de comandos foi removido do servidor por seguranca.";
} else {
    echo "\n\nERRO: Nao foi possivel remover o arquivo de execucao. Remova-o manualmente: " . __FILE__;
}
*/