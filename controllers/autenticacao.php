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
    
    var_dump($usuario);
    if($usuario instanceof Usuario){
        
    }
})
->name('autenticar');


/**
 * Realiza o processo de saída do sistema
 */
$app->get('/logout', function() use($app){
    
})
->name('logout');
