<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios', function() use($app){    
    
    $user = WebUser::getInstance();
        
//    echo "<pre>"; print_r($atendimentos); echo "</pre>";
    
    $app->render('relatorios/consultar.html.twig', array(
        'menuPrincipal' => 'relatorios_gerenciais',
        'user' => $user
    ));
})
->name('relatorios_gerenciais_admin');

/**
 * Tela de novo atendimento
 */
$app->get('/admin/usuarios', function() use($app){    

	$u = WebUser::getInstance();

    $app->render('usuarios/consultar.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'user' 			=> $u
    ));
})
->name('lista_usuarios');

/**
* Listagem de áreas
*/
$app->get('/admin/areas', function($id) use($app){
	$u = WebUser::getInstance();
	
	$app->render('areas/consultar.html.twig', array(
		'menuPrincipal' => 'cadastro_areas',
		'user'			=> $u
	));
})
->name('lista_areas');


$app->get('/admin/dashboard', function() use($app){
	$u = WebUser::getInstance();	
	
	$app->render('admin/dashboard.html.twig', array(
		'menuPrincipal' => 'dashboard',
		'user'			=> $u
	));
})
->name('dashboard_admin');