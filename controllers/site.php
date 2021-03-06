<?php

global $app;

// Pagina inicial
$app->get('/', function() use($app) {
    
    $user = WebUser::getInstance();
    
    if($user->isLogado()){
        if($user->isUsuario()){
            if($user->getUsuario()->isAtendente()){
                $app->redirectTo('consultar_atendimento');
            }
            else if($user->getUsuario()->isResponsavelArea()){
                $app->redirectTo('consultar_atendimento');
            }
            else if($user->getUsuario()->isAdministrador()){
                $app->redirectTo('dashboard_admin');
            }
        }
        // Cliente
        else {
            $app->redirectTo('consultar_atendimento');
        }
    }
    else {    
        
        // Cadastra o acesso ao site
        $em = Conexao::getEntityManager();
        $E = new Empresas();        
        $em->persist(new AcessoEmpresa($E->getAdmin()));
        $em->flush();
        
        $app->render('home/index.html.twig', array(
            'user' => $user,        
            'flash' => isset($_SESSION['slim.flash']) ? $_SESSION['slim.flash'] : false
        ));
    }
})
->name("home");

