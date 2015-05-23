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