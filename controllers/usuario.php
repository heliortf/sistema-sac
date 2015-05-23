<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de consulta de atendimentos
 */
$app->get('/usuarios/por-area/:areaId', function($areaId) use($app){    
    // Usuario logado
    $user = WebUser::getInstance();
    
    // Consulta as areas
    $A = new Areas();
    $area = $A->getArea(array(
        'usuario'   => $user->getUsuario(),
        'id'        => $areaId
    ));
    
    // Consulta os usuarios da area
    $U = new Usuarios();
    $usuarios = $U->getLista(array(
        'usuario'       => $user->getUsuario(),
        'area'          => $area,
        'pagina'        => 0,
        'qtdPorPagina'  => 200
    ));
    
    $json = array('resposta' => 'OK', 'usuarios' => array());
    
    foreach($usuarios['registros'] as $usuario){
        $json['usuarios'][] = array(
            'id'    => $usuario->getId(),
            'nome'  => $usuario->getNome(),
            'cargo' => $usuario->getCargo()->getNome(),
            'perfil'    => $usuario->getPerfil()->getNome()
        );
    }
    
    header("Content-type: application/json");
    echo json_encode($json);
})
->name('get_usuarios_por_area');

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


$app->get('/atendimentos/:id/encaminhar', function($id) use($app){
	$u = WebUser::getInstance();
	
	$A = new Atendimentos();
	$atendimento = $A->getAtendimento(array(
		'usuario' 	=> $u->getUsuario(),
		'id'		=> $id
	));
	
	$A2 = new Areas();
	$areas = $A2->getListaAreas(array(
		'usuario' => $u->getUsuario(),
		'pagina'	=> 0,
		'qtdPorPagina' => 100
	));
	
	$app->render('atendimento/encaminhar.html.twig', array(
		'menuPrincipal' => 'consultar_atendimento',
		'user'			=> $u,
		'atendimento'	=> $atendimento,
		'areas'			=> $areas['registros']
	));
})
->name('encaminhar_atendimento');


$app->get('/atendimentos/cadastrar-comentario', function() use($app){
	$u = WebUser::getInstance();
		
})
->name('cadastrar_comentario_atendimento');



$app->get('/atendimentos/cadastrar-comentario', function() use($app){
	$u = WebUser::getInstance();
		
})
->name('cadastrar_resolucao_atendimento');