<?php

namespace App\Controllers;

use MicroPHP\Injector;

class Controller
{
    protected $injector;

    public function  __construct(Injector $injector)
    {
        $this->injector = $injector;
    }

    public function __get($name)
    {
        if($this->injector->has($name)){
            return $this->injector->get($name);
        }
    }

}