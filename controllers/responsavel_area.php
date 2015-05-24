<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de consulta de atendimentos
 */
$app->get('/responsavel/dashboard', function() use($app){    
    
    $user = WebUser::getInstance();
        
//    echo "<pre>"; print_r($atendimentos); echo "</pre>";
    
    $app->render('responsavel_area/dashboard.html.twig', array(
        'menuPrincipal' => 'dashboard',
        'user' => $user
    ));
})
->name('dashboard_responsavel_area');