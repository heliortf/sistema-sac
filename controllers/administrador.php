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
 * Tela de listagem de usuarios
 */
$app->get('/admin/usuarios', function() use($app){    

    $u = WebUser::getInstance();

    $U = new Usuarios();
    $listaUsuarios = $U->getLista(array(
        'usuario'       => $u->getUsuario(),
        'pagina'        => 1,
        'qtdPorPagina'  => 20,
        'nome'          => "%".$app->request->get('nome', '')."%"
    ));

    $app->render('usuarios/consultar.html.twig', array(
        'menuPrincipal'         => 'cadastro_usuario',
        'user' 			=> $u,
        'usuarios'              => $listaUsuarios['registros'],
        'paginacao'             => $listaUsuarios['paginacao'],
        'filtro'                => array(
            'nome'  => $app->request->get('nome')
        )
    ));
})
->name('lista_usuarios');

/**
 * Tela de novo usuario
 */
$app->get('/admin/usuarios/novo', function() use($app){    

    $u = WebUser::getInstance();
    
    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario()
    ));
    
    $app->render('usuarios/novo.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'user' 		=> $u,
        'areas'         => $areas['registros']
    ));
})
->name('novo_usuario');


$app->get('/admin/usuarios/salvar', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario' => $u->getUsuario(),
        'id' => $id
    ));
})
->name('salvar_usuario');

$app->get('/admin/usuarios/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario' => $u->getUsuario(),
        'id' => $id
    ));
})
->name('ver_usuario');

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

/**
 * Tela de nova area
 */
$app->get('/admin/areas/nova', function($id) use($app){
	$u = WebUser::getInstance();
	
	$app->render('areas/nova.html.twig', array(
		'menuPrincipal' => 'cadastro_areas',
		'user'			=> $u
	));
})
->name('nova_area');


$app->get('/admin/dashboard', function() use($app){
	$u = WebUser::getInstance();	
	
	$app->render('admin/dashboard.html.twig', array(
		'menuPrincipal' => 'dashboard',
		'user'			=> $u
	));
})
->name('dashboard_admin');