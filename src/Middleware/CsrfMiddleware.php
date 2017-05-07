<?php
namespace App\Middleware;

use MicroPHP\Csrf;
use MicroPHP\Injector;

class CsrfMiddleware
{
    protected $injector;

    public function  __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __invoke($route)
    {
        $csrf = $this->injector->get('csrf');
        $key = $csrf->getTokenName();
        $csrf_token = $csrf->createToken();
        $value = '<input type="hidden" name="' . $key . '" value ="' . $csrf_token . '">';
        $this->injector->get('renderer')->twig->addGlobal('csrf_field', $value);

        return true;
    }
}