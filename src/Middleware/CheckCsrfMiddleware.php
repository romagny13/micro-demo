<?php

namespace App\Middleware;

use MicroPHP\Csrf;
use MicroPHP\Injector;

class CheckCsrfMiddleware
{
    protected $injector;

    public function  __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke($route)
    {
        $csrf = $this->injector->get('csrf');
        if($route->method === 'POST' &&   $csrf->hasStoredToken()) {
             if(!$csrf->check()){
                 echo 'Check Csrf token failed';
                 exit;
             }
        }
        return true;
    }
}