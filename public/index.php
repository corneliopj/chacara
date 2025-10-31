<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define('LARAVEL_START', microtime(true));

// Tenta localizar o autoloader do Composer (corrigindo problemas com subdiretórios)
$autoloader = __DIR__.'/../vendor/autoload.php';

if (! file_exists($autoloader)) {
    die('O autoloader do Composer não foi encontrado. Execute "composer install".');
}

require $autoloader;

// Obtém o Application Container (o coração do Laravel)
$app = require_once __DIR__.'/../bootstrap/app.php';

// Cria a instância do Kernel HTTP
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Trata a requisição (lê o routes/web.php, inicializa facades, etc.)
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);