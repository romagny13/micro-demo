<?php
$injector = $app->injector;

$injector
    ->register('auth', \App\Auth\Auth::class)
    ->register('AuthMiddleware', \App\Middleware\AuthMiddleware::class, [$injector])
    ->register('csrf', \MicroPHP\Csrf\Csrf::class)
    ->register('CheckCsrfMiddleware', \App\Middleware\CheckCsrfMiddleware::class, [$injector])
    ->register('CsrfMiddleware', \App\Middleware\CsrfMiddleware::class, [$injector])
    ->register('flash', \MicroPHP\Flash\Flash::class)
    ->register('HomeController', \App\Controllers\HomeController::class, [$injector])
    ->register('PostController', \App\Controllers\PostController::class, [$injector])
    ->register('AuthController', \App\Controllers\AuthController::class, [$injector]);


// add variables to twig
$renderer = $app->renderer;
$renderer->twig->addGlobal('flash', $injector->get('flash'));
$renderer->twig->addGlobal('auth',[
    'isLogged' => $injector->get('auth')->isLogged(),
    'user' => $injector->get('auth')->user()
]);

$renderer->twig->addFunction(new Twig_SimpleFunction('canAddPost',function() use($injector){
    return $injector->get('auth')->canAddPost();
}));

$renderer->twig->addFunction(new Twig_SimpleFunction('canEditPost',function($post) use($injector){
    return $injector->get('auth')->canEditPost($post);
}));


