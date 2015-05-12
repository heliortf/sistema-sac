<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Realiza o processo de autenticação do usuario no sistema
 */
$app->post('/autenticar', function() use($app){    
    $login = $app->request->post('login');
    $senha = $app->request->post('senha');
    
    $a = new Autenticacao();
    $usuario = $a->autenticar(array(
        'login' => $login,
        'senha' => $senha
    ));
    
    if($usuario !== false){
        $em = Conexao::getEntityManager();
        $usuario = $em->find('Usuario', 1);
        var_dump($usuario); die();
        $_SESSION['usuario'] = $usuario;
    }
    else {
        $app->flash('error', 'Usuário e/ou senha inválidos');
        $app->redirectTo('home');
    }
})
->name('autenticar');


/**
 * Realiza o processo de saída do sistema
 */
$app->get('/logout', function() use($app){
    
})
->name('logout');
