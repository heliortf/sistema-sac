<?php

require_once("vendor/autoload.php");

$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

// Pagina inicial
$app->get('/', function() use($app) {
    $app->render('home/index.php');
})->name("home");

$app->run();

