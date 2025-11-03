<?php
// public/test_db_connection.php

// -----------------------------------------------------
// ATENÇÃO: COPIE AS VARIÁVEIS EXATAS DO SEU ARQUIVO .env
// -----------------------------------------------------
/**
$host = 'sql.freedb.tech';
$port = 3306;
$database = 'freedb_chacara';
$username = 'freedb_petersen';
$password = 'Q*?%?PxcU4XwW5A'; // Assegure-se de que a senha esteja correta
*/
$host = '65.19.154.94';
$port = 3306;
$database = 'petersen_chacara';
$username = 'petersen_chacara';
$password = '@@@vqFOB98y7p'; // Assegure-se de que a senha esteja correta

// -----------------------------------------------------

echo "<h2>Status do Teste de Conexão MySQL (PHP Nativo)</h2>";

// Usa a extensão MySQLi do PHP para testar a conexão
$mysqli = new mysqli($host, $username, $password, $database, $port);

if ($mysqli->connect_error) {
    echo "<p style='color: red; font-weight: bold;'>❌ FALHA NA CONEXÃO!</p>";
    echo "<p><strong>Erro de Conexão (Código {$mysqli->connect_errno}):</strong> {$mysqli->connect_error}</p>";
    echo "<p>Isso confirma que o ambiente PHP Web (8.3.25) <strong>NÃO</strong> consegue alcançar o banco de dados {$host}:{$port}.</p>";
    echo "<p><strong>Próximas Etapas:</strong></p>";
    echo "<ul>";
    echo "<li>Verificar se o servidor DB em {$host} está ativo.</li>";
    echo "<li>Contactar a hospedagem: Pedir para verificar se há um <strong>firewall de saída</strong> que bloqueia a porta {$port} (3305) para hosts externos.</li>";
    echo "</ul>";
} else {
    echo "<p style='color: green; font-weight: bold;'>✅ SUCESSO NA CONEXÃO!</p>";
    echo "<p>O PHP Web conseguiu se conectar ao banco de dados.</p>";
    echo "<p><strong>Próximas Etapas:</strong></p>";
    echo "<ul>";
    echo "<li>O problema é no Laravel. Garanta que o <code>SESSION_DRIVER</code> e <code>CACHE_STORE</code> no <code>.env</code> estejam como <code>file</code> e rode <code>php artisan config:clear</code>.</li>";
    
    // Testa uma consulta simples para garantir que a autenticação foi bem-sucedida
    $result = $mysqli->query("SELECT 1 + 1 AS dois");
    if ($result) {
        $row = $result->fetch_assoc();
        echo "<li>Teste de Consulta Simples: {$row['dois']} (OK)</li>";
    }
    
    echo "</ul>";
    $mysqli->close();
}

// -----------------------------------------------------
// OBRIGATÓRIO: EXCLUA ESTE ARQUIVO APÓS O TESTE POR SEGURANÇA!
// -----------------------------------------------------