<?php

namespace App;

use Symfony\Component\Routing\Route;

/**
 *
 */
class Router
{
    /**
     * @var Route[]
     */
    private array $routes;

    public function append(string $path, array $action, array $methods, string $name, array $requirements = []): void
    {
        $route = new Route($path, ['_controller' => [$action[0], $action[1]]]);
        $route->setMethods($methods);
        $route->addRequirements($requirements);

        $this->routes[$name] = $route;
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
