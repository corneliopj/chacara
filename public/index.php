<?php
// public/index.php - Bootstrap e Roteamento Manual

// Simulação de autoloading manual de classes
function my_autoloader($class) {
    $path = str_replace('\\', '/', $class);
    // Assumindo que Controllers estão em App/Controllers e Models em App/Models
    if (file_exists("App/{$path}.php")) {
        require_once "App/{$path}.php";
    } elseif (file_exists("{$path}.php")) {
        require_once "{$path}.php";
    }
}
spl_autoload_register('my_autoloader');

// Função para renderizar Blade (simulação)
function view($view_path, $data = []) {
    // Transforma o array $data em variáveis locais
    extract($data);
    
    // Define onde a view principal será encontrada para o layout usá-la.
    $view_content_file = __DIR__ . "/../resources/views/{$view_path}.blade.php";
    
    // Simula a inclusão do layout principal
    $layout_file = __DIR__ . "/../resources/views/layout/master.blade.php";

    if (file_exists($view_content_file) && file_exists($layout_file)) {
        ob_start();
        
        // Incluímos o layout, que por sua vez, deve incluir $view_content_file
        include $layout_file; 
        
        return ob_get_clean();
    } else {
        // Lógica simplificada de erro para views não encontradas
        return "Erro: View '{$view_path}' ou Layout 'master' não encontrada.";
    }
}

// Inclusão das Rotas
require_once __DIR__ . '/../routes/web.php';

// Roteador manual (muito simplificado)
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$method = $_SERVER['REQUEST_METHOD'];

$route_found = false;
foreach ($routes as $route) {
    if ($route['method'] === $method && $route['uri'] === $uri) {
        $controller_name = $route['controller'];
        $action = $route['action'];

        // Instancia o Controller e chama a Action
        $controller_class = "App\\Controllers\\{$controller_name}";
        if (class_exists($controller_class)) {
            $controller = new $controller_class();
            echo $controller->$action();
            $route_found = true;
            break;
        }
    }
}

if (!$route_found) {
    http_response_code(404);
    echo view('404'); // Simula uma view 404
}