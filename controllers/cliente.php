<?php

global $app;

// Consulta de clientes e retorno em json
$app->get('/clientes/buscar/:query', function($query) use($app) {
    
    $user = WebUser::getInstance();
    
	$C = new Clientes();
	$clientes = $C->getListaClientes(array(
		'text'			=> $query,
		'pagina' 		=> 0,
		'qtdPorPagina' 	=> 20
	));
	
	$arrayClientes = array();
	foreach($clientes as $cliente){
		$arrayClientes[] = array(
			'id' => $cliente->getId(),
			'nome' => $cliente->getNome(),
			'cpf' => $cliente->getCpf()
		);
	}
	
	$app->response->headers->set('Content-Type', 'application/json');
	$app->response->setBody(json_encode($arrayClientes));
})
->name("buscar_clientes");

// Consulta de clientes e retorno em json
$app->get('/clientes/:cliente/get-documentos/', function($cliente) use($app) {
    
    $user = WebUser::getInstance();
    
    $C = new Clientes();
    $clienteBD = $C->getCliente(array(
        'id' => $cliente,
        'usuario' => $user->getUsuario()
    ));
	
    $arrayDocumentos = array();
    $documentos = $clienteBD->getDocumentos();
    foreach($documentos as $d){
        $arrayDocumentos[] = array(
            'id'    => $d->getId(),
            'titulo'  => $d->getTitulo()
        );
    }

    $app->response->headers->set('Content-Type', 'application/json');
    $app->response->setBody(json_encode($arrayDocumentos));
})
->name("buscar_documentos_cliente");

