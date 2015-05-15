<?php

global $app;

// Pagina inicial
$app->get('/', function() use($app) {
    
    $user = WebUser::getInstance();
    
    if($user->isLogado()){
        $app->redirectTo('consultar_atendimento');
    }
    else {    
        $app->render('home/index.html.twig', array(
            'user' => $user,        
            'flash' => isset($_SESSION['slim.flash']) ? $_SESSION['slim.flash'] : false
        ));
    }
})
->name("home");

