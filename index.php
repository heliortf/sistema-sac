<?php

require_once("vendor/autoload.php");
require_once("config/autoload.php");

$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

// Pagina inicial
$app->get('/', function() use($app) {
    $app->render('home/index.php');
})->name("home");


$app->get('/gerar-banco', function() use($app){
    
})->name("gerar_banco");

$app->run();

