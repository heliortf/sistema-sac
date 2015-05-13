<?php

global $app;

// Pagina inicial
$app->get('/', function() use($app) {
    
    $app->render('home/index.html.twig', array(
        'user' => WebUser::getInstance(),        
        'flash' => isset($_SESSION['slim.flash']) ? $_SESSION['slim.flash'] : false,
        'urlAutenticar' => $app->urlFor('autenticar')
    ));
})
->name("home");

