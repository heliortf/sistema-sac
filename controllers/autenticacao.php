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
    
    $E = new Empresas();
    
    // Se está na pagina principal e nao informou a empresa..
    if($app->request->post('empresa', null) == null){
        $empresa = $E->getAdmin();
    }
    else {
        $empresa = null;
    }
    
    $a = new Autenticacao();
    $usuario = $a->autenticar(array(
        'login'     => $login,
        'senha'     => $senha,
        'empresa'   => $empresa
    ));    
    
//    var_dump($usuario); die();
    
    if($usuario instanceof Usuario){
        $_SESSION['usuario'] = $usuario->getId();
        $_SESSION['tipo_usuario'] = 'usuario';
        $app->flash('sucesso', 'Bem vindo, '.$usuario->getNome());
        $app->redirectTo('home');
    }
    // Se logar como cliente
    else if($usuario instanceof Cliente){
        $_SESSION['usuario'] = $usuario->getId();
        $_SESSION['tipo_usuario'] = 'cliente';
        $app->flash('sucesso', 'Bem vindo, '.$usuario->getNome());
        $app->redirectTo('home');
    }
    else {
            $app->flash('erro', "Usuário e/ou senha inválidos");
            $app->redirectTo('home');
    }
})
->name('autenticar');


/**
 * Realiza o processo de saída do sistema
 */
$app->get('/logout', function() use($app){
    session_destroy();    
    $app->redirectTo('home');
})
->name('logout');
