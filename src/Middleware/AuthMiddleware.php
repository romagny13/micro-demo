<?php

namespace App\Middleware;


use MicroPHP\Injector;

class AuthMiddleware
{
    protected $injector;

    public function  __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke($route)
    {
        if(!$this->injector->get('auth')->authorize()){
            $this->injector->get('flash')->addMessage('error','You have no permission to access to this ressource.');
            $route->router->go('auth.signin');
            return false;
        }
        return true;
    }
}