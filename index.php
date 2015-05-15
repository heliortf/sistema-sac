<?php

session_start();

require_once("vendor/autoload.php");
require_once("config/autoload.php");

global $app;

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

ini_set('max_execution_time', 60);

ini_set('memory_limit ', '128M');

require_once('controllers/site.php');
require_once('controllers/autenticacao.php');
require_once('controllers/atendimento.php');


$app->run();

