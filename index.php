<?php

require_once("vendor/autoload.php");
require_once("config/autoload.php");

$app = new \Slim\Slim(array(
    'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
    'debug' => true,
    'cache' => dirname(__FILE__) . '/cache'
);
$view->parserExtensions = array(
    new \Slim\Views\TwigExtension()
);


// Pagina inicial
$app->get('/', function() use($app) {
    $app->render('home/index.html.twig');
})->name("home");


$app->get('/gerar-banco', function() use($app){
    
})->name("gerar_banco");

$app->run();

