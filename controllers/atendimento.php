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
    
    $user = WebUser::getInstance();
    
    $A = new Atendimentos();
    $atendimentos = $A->getListaAtendimentos(array(
        'usuario'       => $user->getUsuario(),
        'pagina'        => 0,
        'qtdPorPagina'  => 20
    ));
    
//    echo "<pre>"; print_r($atendimentos); echo "</pre>";
    
    $app->render('atendimento/consultar.html.twig', array(
        'menuPrincipal' => 'consultar_atendimento',
        'atendimentos'  => $atendimentos['registros'],
        'user' => $user
    ));
})
->name('consultar_atendimento');

/**
 * Tela de novo atendimento
 */
$app->get('/atendimentos/novo', function() use($app){    

	$u = WebUser::getInstance();

	$C = new Clientes();
	$clientes = $C->getListaClientes(array(
		'usuario' 		=> $u->getUsuario(),
		'text' 			=> '%',
		'pagina' 		=> 0,
		'qtdPorPagina' 	=> 100
	));

    $app->render('atendimento/novo.html.twig', array(
        'menuPrincipal' => 'registrar_atendimento',
        'user' 			=> $u,
		'clientes' 		=> $clientes['registros']
    ));
})
->name('novo_atendimento');

$app->get('/atendimentos/:id', function($id) use($app){
	$u = WebUser::getInstance();
	
	$A = new Atendimentos();
	$atendimento = $A->getAtendimento(array(
		'usuario' 	=> $u->getUsuario(),
		'id'		=> $id
	));
	
	$app->render('atendimento/ver.html.twig', array(
		'menuPrincipal' => 'consultar_atendimento',
		'user'			=> $u,
		'atendimento'	=> $atendimento
	));
})
->name('ver_atendimento');


$app->get('/atendimentos/:id/realizar', function($id) use($app){
	$u = WebUser::getInstance();
	
	$A = new Atendimentos();
	$atendimento = $A->getAtendimento(array(
		'usuario' 	=> $u->getUsuario(),
		'id'		=> $id
	));
	
	$app->render('atendimento/resolucao.html.twig', array(
		'menuPrincipal' => 'consultar_atendimento',
		'user'			=> $u,
		'atendimento'	=> $atendimento
	));
})
->name('resolucao_atendimento');




$app->get('/atendimentos/cadastrar-comentario', function() use($app){
	$u = WebUser::getInstance();
		
})
->name('cadastrar_comentario_atendimento');



$app->get('/atendimentos/cadastrar-comentario', function() use($app){
	$u = WebUser::getInstance();
		
})
->name('cadastrar_resolucao_atendimento');