<?php

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

require_once('controllers/site.php');
require_once('controllers/autenticacao.php');


$app->run();

