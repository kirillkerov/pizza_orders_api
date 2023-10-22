<?php

header('Content-Type: application/json; charset=UNF-8');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

use App\Controllers\OrdersController;
use App\Router;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

$router = new Router();
$router->append('/orders', [OrdersController::class, 'create'], ['POST'], 'orders_create');
$router->append('/orders', [OrdersController::class, 'list'], ['GET'], 'orders_list');
$router->append('/orders/{order_id}/items', [OrdersController::class, 'append'], ['POST'], 'orders_append', ['order_id' => '[^\s\/]{3,15}']);
$router->append('/orders/{order_id}', [OrdersController::class, 'get'], ['GET'], 'orders_get', ['order_id' => '[^\s\/]{3,15}']);
$router->append('/orders/{order_id}/done', [OrdersController::class, 'done'], ['POST'], 'orders_done', ['order_id' => '[^\s\/]{3,15}']);

$collection = new RouteCollection();
foreach ($router->getRoutes() as $name => $route) {
    $collection->add($name, $route);
}

$matcher = new UrlMatcher($collection, new RequestContext('/', $_SERVER["REQUEST_METHOD"]));

try {
    $match = $matcher->match(strtok($_SERVER["REQUEST_URI"], '?'));
} catch (Exception $e) {
    die($e->getMessage() ?: 'No routes found for this path');
}

$params = [];
foreach ($match as $key => $value) {
    switch ($key) {
        case '_controller':
            $controllerClassName = $value[0];
            $controllerActionName = $value[1];
            break;
        case '_route':
            break;
        default:
            $params[$key] = $value;
            break;
    }
}

try {
    $controller = new $controllerClassName();
    call_user_func_array([$controller, $controllerActionName], array_merge($params, $_GET));
} catch (Exception $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
