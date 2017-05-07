<?php

use MicroPHP\App;
use MicroPHP\Db\Db;

require __DIR__ . '/../vendor/autoload.php';

session_start();

$settings = [
    'base' => 'http://localhost:8080/',
    'templates' => __DIR__.'/../templates',
    'db' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'blog',
        'username' => 'root',
        'password' => '',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ]
];
$app = new App($settings);
$router = $app->router;

$dsn = 'mysql:host=' . $settings['db']['host'] . ';dbname=' . $settings['db']['database'];
Db::setConnectionStringSettings($dsn,$settings['db']['username'],$settings['db']['password']);

// dependencies
require __DIR__ . '/../src/dependencies.php';

// routes
require __DIR__ . '/../src/routes.php';
//
$router->run();


