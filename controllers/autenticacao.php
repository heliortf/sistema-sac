<?php

/**
 * 
 */
global $app;

/**
 * Realiza o processo de autenticação do usuario no sistema
 */
$app->post('/autenticar', function() use($app){    
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    
    $a = new Autenticacao();
    $usuario = $a->autenticar(array(
        'login' => $login,
        'senha' => $senha
    ));    
    
    if($usuario instanceof Usuario){
        $_SESSION['usuario'] = $usuario->getId();
		$app->flash('sucesso', 'Bem vindo, '.$usuario->getNome());
		$app->redirectTo('home');
    }
	else {
		$app->flash('erro', "Usuário e/ou senha inválidos");
	}
})
->name('autenticar');


/**
 * Realiza o processo de saída do sistema
 */
$app->get('/logout', function() use($app){
    
})
->name('logout');
