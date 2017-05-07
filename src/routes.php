<?php

$router->get('/', 'HomeController:index')->setName('home');

$router->group('/auth', function(){
    $this->get('/signup', 'AuthController:getSignup')->setName('auth.signup');
    $this->post('/signup', 'AuthController:postSignup');
    $this->get('/signin', 'AuthController:getSignin')->setName('auth.signin');
    $this->post('/signin', 'AuthController:postSignin');
    $this->get('/signout', 'AuthController:getSignout')->setName('auth.signout');
});

$router->group('/posts', function(){
    $this->get('', 'PostController:index')->setName('posts.index');
    $this->get('/create', 'PostController:getCreate')->setName('posts.create')->add('AuthMiddleware');
    $this->post('/create', 'PostController:postCreate');
    $this->post('/delete', 'PostController:deletePost')->setName('posts.delete');
});

$router->get('.*', function($route){
    $route->router->go('home');
});

// caution execution order(from start to end)
$router
    ->add($injector->get('CheckCsrfMiddleware'))
    ->add($injector->get('CsrfMiddleware'));
