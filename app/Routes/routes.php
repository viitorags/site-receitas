<?php

require __DIR__ . "/../Controllers/ReceitasController.php";

class Router
{
    private $routes = [];

    public function add($method, $path, $handler)
    {
        $this->routes[$method][$path] = $handler;
    }

    public function dispatch($method, $path)
    {
        if (isset($this->routes[$method][$path])) {
            call_user_func($this->routes[$method][$path]);
        } else {
            http_response_code(404);
        }
    }
}

$router = new Router();
$router->add('GET', '/', function () {
    $controller = new ReceitasController();
    $controller->listarReceitas();
});
$router->add('POST', '/api/receitas', function () {
    $controller = new ReceitasController();
    $controller->criarNovaReceita();
});
$router->add('PUT', '/api/receitas', function () {
    $controller = new ReceitasController();
    $controller->atualizarReceita();
});
$router->add('DELETE', '/api/receitas', function () {
    $controller = new ReceitasController();
    $controller->deletarReceita();
});
