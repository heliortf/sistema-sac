<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de consulta de atendimentos
 */
$app->get('/atendimentos', function() use($app){    
    $app->render('atendimento/consultar.html.twig', array(
        'menuPrincipal' => 'consultar_atendimento',
        'user' => WebUser::getInstance()
    ));
})
->name('consultar_atendimento');

/**
 * Tela de novo atendimento
 */
$app->get('/atendimentos/novo', function() use($app){    
    $app->render('atendimento/novo.html.twig', array(
        'menuPrincipal' => 'registrar_atendimento',
        'user' => WebUser::getInstance()
    ));
})
->name('novo_atendimento');

