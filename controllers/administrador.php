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
    
    $C = new Cargos();
    $cargos = $C->getListaCargos(array(
        'usuario' => $u->getUsuario()
    ));
    
    $app->render('usuarios/novo.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'user' 		=> $u,
        'areas'         => $areas['registros'],
        'cargos'        => $cargos['registros']
    ));
})
->name('novo_usuario');


$app->get('/admin/usuarios/salvar', function($id) use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a area
    $A = new Areas();
    $Area = $A->getArea(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('area')
    ));

    // Consulta o cargo
    $C = new Cargos();
    $Cargo = $C->getCargo(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('cargo')
    ));
    
    // Classe que persiste o usuario
    $U = new Usuarios();
    
    // Usuario
    $Usuario = new Usuario();
    $Usuario->setEmpresa($u->getUsuario()->getEmpresa());
    $Usuario->setArea($Area);
    $Usuario->setCargo($Cargo);
    $Usuario->setNome($app->request->post('nome'));
    $Usuario->setEmail($app->request->post('email'));
    $Usuario->setCPF($app->request->post('cpf'));
    $Usuario->setLogin($app->request->post('login'));
    $Usuario->setSenha($app->request->post('senha'));
    $Usuario->setDddTelefone($app->request->post('ddd_telefone'));
    $Usuario->setTelefone($app->request->post('telefone'));    
    $Usuario->setDddCelular($app->request->post('ddd_celular'));
    $Usuario->setCelular($app->request->post('celular'));
    
    $U->salvar($Usuario);
    
    $app->redirectTo('ver_usuario', array(
        'id' => $Usuario->getId()
    ));
})
->name('salvar_usuario');

$app->get('/admin/usuarios/:id/editar', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    
    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario()
    ));
    
    $C = new Cargos();
    $cargos = $C->getListaCargos(array(
        'usuario' => $u->getUsuario()
    ));
    
    $app->render('usuarios/editar.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'usuario'       => $usuario,
        'areas'         => $areas['registros'],
        'cargos'        => $cargos['registros'],
        'user'          => $u
    ));
})
->name('editar_usuario');

$app->get('/admin/usuarios/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('usuarios/ver.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'usuario'       => $usuario,
        'user'          => $u
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