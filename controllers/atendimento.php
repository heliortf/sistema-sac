<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de consulta de atendimentos
 */
$app->get('/atendimentos', function() use($app) {

            $user = WebUser::getInstance();

            $A = new Atendimentos();
            $atendimentos = $A->getListaAtendimentos(array(
                'usuario' => $user->getUsuario(),
                'pagina' => 0,
                'qtdPorPagina' => 20
            ));

//    echo "<pre>"; print_r($atendimentos); echo "</pre>";

            $app->render('atendimento/consultar.html.twig', array(
                'menuPrincipal' => 'consultar_atendimento',
                'atendimentos' => $atendimentos['registros'],
                'user' => $user
            ));
        })
        ->name('consultar_atendimento');

/**
 * Tela de novo atendimento
 */
$app->get('/atendimentos/novo', function() use($app) {

    $u = WebUser::getInstance();

    $C = new Clientes();
    $clientes = $C->getListaClientes(array(
        'usuario' => $u->getUsuario(),
        'text' => '%',
        'pagina' => 0,
        'qtdPorPagina' => 100
    ));

    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario(),        
    ));
	
	$T = new TiposAtendimento();
	$tipos = $T->getListaTipoAtendimentos();

    $app->render('atendimento/novo.html.twig', array(
        'menuPrincipal' => 'registrar_atendimento',
        'user'          => $u,
        'areas'         => $areas['registros'],
        'clientes'      => $clientes['registros'],
		'tipos'			=> $tipos['registros']
    ));
})
->name('novo_atendimento');

/**
 * Ação para salvar um novo atendimento
 */
$app->post('/atendimentos/salvar', function() use($app) {

    $u = WebUser::getInstance();

    # Consulta o cliente recebido
    $C = new Clientes();
    $cliente = $C->getCliente(array(
        'id'        => $app->request->post('cliente'),
        'usuario'   => $u->getUsuario()
    ));

    # Consulta a area recebida
    $A = new Areas();
    $area = $A->getArea(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $app->request->post('area')
    ));
	
	$T = new TiposAtendimento();
	$tipo = $T->getTipoAtendimento(array(		
		'id' => $app->request->post('tipo')
	));	
	
    # Cria o atendimento
    $a = new Atendimento();
	$a->setTipo($tipo);
    $a->setEmpresa($u->getUsuario()->getEmpresa());    
    $a->setCliente($cliente);
    $a->setArea($area);
    $a->setTitulo($app->request->post('titulo'));
    $a->setDescricao($app->request->post('descricao'));
    $a->setDataCriacao(new DateTime());
	$a->setCriadoPor($u->getUsuario()->getNome());

    $Atendimentos = new Atendimentos();
    $a = $Atendimentos->salvar($a);
    
    $app->redirect($app->urlFor('ver_atendimento', array('id' => $a->getId())));
})
->name('salvar_atendimento');


$app->get('/atendimentos/:id', function($id) use($app) {
    $u = WebUser::getInstance();

    $A = new Atendimentos();
    $atendimento = $A->getAtendimento(array(
        'usuario' => $u->getUsuario(),
        'id' => $id
    ));

    $app->render('atendimento/ver.html.twig', array(
        'menuPrincipal' => 'consultar_atendimento',
        'user' => $u,
        'atendimento' => $atendimento
    ));
})
->name('ver_atendimento');


$app->get('/atendimentos/:id/realizar', function($id) use($app) {
            $u = WebUser::getInstance();

            $A = new Atendimentos();
            $atendimento = $A->getAtendimento(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $app->render('atendimento/resolucao.html.twig', array(
                'menuPrincipal' => 'consultar_atendimento',
                'user' => $u,
                'atendimento' => $atendimento
            ));
        })
        ->name('resolucao_atendimento');


$app->get('/atendimentos/:id/encaminhar', function($id) use($app) {
            $u = WebUser::getInstance();

            $A = new Atendimentos();
            $atendimento = $A->getAtendimento(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $A2 = new Areas();
            $areas = $A2->getListaAreas(array(
                'usuario' => $u->getUsuario(),
                'pagina' => 0,
                'qtdPorPagina' => 100
            ));

            $app->render('atendimento/encaminhar.html.twig', array(
                'menuPrincipal' => 'consultar_atendimento',
                'user' => $u,
                'atendimento' => $atendimento,
                'areas' => $areas['registros']
            ));
        })
        ->name('encaminhar_atendimento');


$app->get('/atendimentos/cadastrar-comentario', function() use($app) {
            $u = WebUser::getInstance();
        })
        ->name('cadastrar_comentario_atendimento');



$app->get('/atendimentos/cadastrar-conclusao', function() use($app) {
            $u = WebUser::getInstance();
        })
        ->name('cadastrar_resolucao_atendimento');
