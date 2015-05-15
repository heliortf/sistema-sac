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

