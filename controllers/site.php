<?php

global $app;

// Pagina inicial
$app->get('/', function() use($app) {
    $app->render('home/index.html.twig');
})
->name("home");

