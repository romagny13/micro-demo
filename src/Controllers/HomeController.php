<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index($route){
        return $this->renderer->render('home.twig',[
            'pagetitle' => 'Home',
            'active' => 'home'
        ]);
    }
}