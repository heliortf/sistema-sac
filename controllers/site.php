<?php

global $app;

// Pagina inicial
$app->get('/', function() use($app) {
    
    $user = WebUser::getInstance();
    
    if($user->isLogado()){
        if($user->getUsuario()->isAtendente()){
            $app->redirectTo('consultar_atendimento');
        }
        else if($user->getUsuario()->isResponsavelArea()){
            $app->redirectTo('dashboard_responsavel_area');
        }
        else if($user->getUsuario()->isAdministrador()){
            $app->redirectTo('dashboard_admin');
        }
    }
    else {    
        $app->render('home/index.html.twig', array(
            'user' => $user,        
            'flash' => isset($_SESSION['slim.flash']) ? $_SESSION['slim.flash'] : false
        ));
    }
})
->name("home");

