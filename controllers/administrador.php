<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

$app->post('/do-search', function() use($app){    
    $p = $app->request->post('p');
    foreach($p as $k => $v){
        if($v == ''){
            unset($p[$k]);
        }
    }
    $app->redirectTo($app->request->post('rota'), $p);
})
->name('buscar');

/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios', function() use($app){    
    
    $user = WebUser::getInstance();
        
//    echo "<pre>"; print_r($atendimentos); echo "</pre>";
    
    $app->render('relatorios/consultar.html.twig', array(
        'menuPrincipal' => 'relatorios_gerenciais',
        'user' => $user
    ));
})
->name('relatorios_gerenciais_admin');

/**
 * Tela de novo usuario
 */
$app->get('/admin/usuarios/novo', function() use($app){    

    $u = WebUser::getInstance();
    
    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario()
    ));
    
    $C = new Cargos();
    $cargos = $C->getListaCargos(array(
        'usuario' => $u->getUsuario()
    ));
    
    $app->render('usuarios/novo.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'user' 		=> $u,
        'areas'         => $areas['registros'],
        'cargos'        => $cargos['registros']
    ));
})
->name('novo_usuario');


$app->post('/admin/usuarios/salvar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a area
    $A = new Areas();
    $Area = $A->getArea(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('area')
    ));

    // Consulta o cargo
    $C = new Cargos();
    $Cargo = $C->getCargo(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('cargo')
    ));
    
    // Classe que persiste o usuario
    $U = new Usuarios();
    
    // Usuario
    $Usuario = new Usuario();
    $Usuario->setEmpresa($u->getUsuario()->getEmpresa());
    $Usuario->setArea($Area);
    $Usuario->setCargo($Cargo);
    $Usuario->setNome($app->request->post('nome'));
    $Usuario->setEmail($app->request->post('email'));
    $Usuario->setCPF($app->request->post('cpf'));
    $Usuario->setLogin($app->request->post('login'));
    $Usuario->setSenha($app->request->post('senha'));
    $Usuario->setDddTelefone($app->request->post('ddd_telefone'));
    $Usuario->setTelefone($app->request->post('telefone'));    
    $Usuario->setDddCelular($app->request->post('ddd_celular'));
    $Usuario->setCelular($app->request->post('celular'));
    
    $U->salvar($Usuario);
    
    $app->redirectTo('ver_usuario', array(
        'id' => $Usuario->getId()
    ));
})
->name('salvar_usuario');


$app->post('/admin/usuarios/atualizar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a area
    $A = new Areas();
    $Area = $A->getArea(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('area')
    ));

    // Consulta o cargo
    $C = new Cargos();
    $Cargo = $C->getCargo(array(
        'usuario' => $u->getUsuario(),
        'id' => $app->request->post('cargo')
    ));
    
    // Classe que persiste o usuario
    $U = new Usuarios();
    $Usuario = $U->getUsuario(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $app->request->post('id')
    ));
    
    if($Usuario instanceof Usuario){
        $Usuario->setEmpresa($u->getUsuario()->getEmpresa());
        $Usuario->setArea($Area);
        $Usuario->setCargo($Cargo);
        $Usuario->setNome($app->request->post('nome'));
        $Usuario->setEmail($app->request->post('email'));
        $Usuario->setCPF($app->request->post('cpf'));
        $Usuario->setLogin($app->request->post('login'));
        $Usuario->setSenha($app->request->post('senha'));
        $Usuario->setDddTelefone($app->request->post('ddd_telefone'));
        $Usuario->setTelefone($app->request->post('telefone'));    
        $Usuario->setDddCelular($app->request->post('ddd_celular'));
        $Usuario->setCelular($app->request->post('celular'));        

        $U->salvar($Usuario);
        
        $app->flash('sucesso', 'Usuario atualizado com sucesso!');
    
        $app->redirectTo('ver_usuario', array(
            'id' => $Usuario->getId()
        ));
    }
    else {
        $app->flash('erro', 'Usuário não encontrado');
        
        $app->redirectTo('lista_usuarios');
    }
})
->name('atualizar_usuario');

$app->get('/admin/usuarios/:id/editar', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    
    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario()
    ));
    
    $C = new Cargos();
    $cargos = $C->getListaCargos(array(
        'usuario' => $u->getUsuario()
    ));
    
    $app->render('usuarios/editar.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'usuario'       => $usuario,
        'areas'         => $areas['registros'],
        'cargos'        => $cargos['registros'],
        'user'          => $u
    ));
})
->name('editar_usuario');

$app->get('/admin/usuarios/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Usuarios();
    $usuario = $U->getUsuario(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('usuarios/ver.html.twig', array(
        'menuPrincipal' => 'cadastro_usuario',
        'usuario'       => $usuario,
        'user'          => $u
    ));
})
->name('ver_usuario');


/**
 * Tela de listagem de usuarios
 */
$app->get('/admin/usuarios(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina=1, $qtdPorPagina=20, $nome='') use($app){    

    $u = WebUser::getInstance();
    
    $U = new Usuarios();
    $listaUsuarios = $U->getLista(array(
        'usuario'       => $u->getUsuario(),
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina,
        'nome'          => "%".$nome."%"
    ));
    
    $parametros = array(
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina
    );
    
    if(!empty($nome)){
        $parametros['nome'] = $nome;
    }    
    $Paginacao = new Paginacao(array_merge(
        $listaUsuarios['paginacao'], 
        array(
            'parametros' => $parametros,
            'rota' => 'lista_usuarios'
        )
    ));
    
    $app->render('usuarios/consultar.html.twig', array(
        'menuPrincipal'         => 'cadastro_usuario',
        'user' 			=> $u,
        'usuarios'              => $listaUsuarios['registros'],
        'paginacao'             => $Paginacao,
        'filtro'                => array(
            'nome'  => $nome
        )
    ));
})
->name('lista_usuarios');

/**
 * Tela de nova area
 */
$app->get('/admin/areas/nova', function() use($app){
    $u = WebUser::getInstance();

    $app->render('areas/nova.html.twig', array(
            'menuPrincipal' => 'cadastro_areas',
            'user'			=> $u
    ));
})
->name('nova_area');

$app->post('/admin/areas/salvar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Classe que persiste o usuario
    $A = new Areas();
    
    // Area
    $Area = new Area();    
    $Area->setEmpresa($u->getUsuario()->getEmpresa());
    $Area->setNome($app->request->post('nome'));
    
    $A->salvar($Area);
    
    $app->redirectTo('ver_area', array(
        'id' => $Area->getId()
    ));
})
->name('salvar_area');

$app->post('/admin/areas/atualizar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a area
    $A = new Areas();
    $Area = $A->getArea(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $app->request->post('id')
    ));
    
    if($Area instanceof Area){
        $Area->setNome($app->request->post('nome'));        
        $A->salvar($Area);
        
        $app->flash('sucesso', 'Área atualizada com sucesso!');    
        $app->redirectTo('ver_area', array(
            'id' => $Area->getId()
        ));
    }
    else {
        $app->flash('erro', 'Área não encontrada');        
        $app->redirectTo('lista_areas');
    }
})
->name('atualizar_area');

$app->get('/admin/areas/:id/editar', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Areas();
    $area = $U->getArea(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('areas/editar.html.twig', array(
        'menuPrincipal' => 'cadastro_area',
        'area'          => $area,
        'user'          => $u
    ));
})
->name('editar_area');

$app->get('/admin/areas/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Areas();
    $area = $U->getArea(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('areas/ver.html.twig', array(
        'menuPrincipal' => 'cadastro_area',
        'area'          => $area,
        'user'          => $u
    ));
})
->name('ver_area');

/**
* Listagem de áreas
*/
$app->get('/admin/areas(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina=1, $qtdPorPagina=20, $nome='') use($app){
    $u = WebUser::getInstance();

    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario'       => $u->getUsuario(),
        'nome'          => (!empty($nome) ? "%$nome%" : ""),
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina
    ));
        
        
    $parametros = array(
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina
    );
    
    if(!empty($nome)){
        $parametros['nome'] = $nome;
    }    
    
    $Paginacao = new Paginacao(array_merge(
        $areas['paginacao'], 
        array(
            'parametros' => $parametros,
            'rota' => 'lista_areas'
        )
    ));
    
    $app->render('areas/consultar.html.twig', array(
        'menuPrincipal'         => 'cadastro_areas',
        'user' 			=> $u,
        'areas'                 => $areas['registros'],
        'paginacao'             => $Paginacao,
        'filtro'                => array(
            'nome'  => $nome
        )
    ));
})
->name('lista_areas');

/**
 * Tela de nova cliente
 */
$app->get('/admin/clientes/novo', function() use($app){
    $u = WebUser::getInstance();

    $app->render('clientes/nova.html.twig', array(
        'menuPrincipal' => 'cadastro_clientes',
        'user'          => $u
    ));
})
->name('novo_cliente');

$app->post('/admin/clientes/salvar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Classe que persiste o usuario
    $A = new Clientes();
    
    // Cliente
    $Cliente = new Cliente();    
    $Cliente->setEmpresa($u->getUsuario()->getEmpresa());
    $Cliente->setNome($app->request->post('nome'));
    
    $A->salvar($Cliente);
    
    $app->redirectTo('ver_cliente', array(
        'id' => $Cliente->getId()
    ));
})
->name('salvar_cliente');


$app->get('/admin/clientes/importar', function() use($app){    

    $u = WebUser::getInstance();    
	
    $app->render('clientes/importar.html.twig', array(
        'menuPrincipal' => 'cadastro_cliente',        
        'user'          => $u
    ));
})
->name('importar_clientes');


$app->post('/admin/clientes/atualizar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a cliente
    $A = new Clientes();
    $Cliente = $A->getCliente(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $app->request->post('id')
    ));
    
    if($Cliente instanceof Cliente){
        $Cliente->setNome($app->request->post('nome'));   
        $Cliente->setCpf($app->request->post('cpf'));
        $Cliente->setCnpj($app->request->post('cnpj'));
        $Cliente->setEmail($app->request->post('email'));
        $Cliente->setSenha($app->request->post('senha'));
        $Cliente->setDddTelefone($app->request->post('ddd_telefone'));
        $Cliente->setTelefone($app->request->post('telefone'));
        $Cliente->setDddCelular($app->request->post('ddd_celular'));
        $Cliente->setCelular($app->request->post('celular'));
        $A->salvar($Cliente);
        
        $app->flash('sucesso', 'Cliente atualizado com sucesso!');    
        $app->redirectTo('ver_cliente', array(
            'id' => $Cliente->getId()
        ));
    }
    else {
        $app->flash('erro', 'Cliente não encontrado');        
        $app->redirectTo('lista_clientes');
    }
})
->name('atualizar_cliente');


$app->get('/admin/clientes/:id/editar', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Clientes();
    $cliente = $U->getCliente(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('clientes/editar.html.twig', array(
        'menuPrincipal' => 'cadastro_cliente',
        'cliente'          => $cliente,
        'user'          => $u
    ));
})
->name('editar_cliente');

$app->get('/admin/clientes/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Clientes();
    $cliente = $U->getCliente(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $id
    ));
    
    $app->render('clientes/ver.html.twig', array(
        'menuPrincipal' => 'cadastro_cliente',
        'cliente'          => $cliente,
        'user'          => $u
    ));
})
->name('ver_cliente')
->conditions(array('id' => '[0-9]{1,}'));;

/**
* Listagem de áreas
*/
$app->get('/admin/clientes(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina=1, $qtdPorPagina=20, $nome='') use($app){
    $u = WebUser::getInstance();

    $A = new Clientes();
    $clientes = $A->getListaClientes(array(
        'usuario'       => $u->getUsuario(),
        'nome'          => (!empty($nome) ? "%$nome%" : ""),
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina
    ));
        
        
    $parametros = array(
        'pagina'        => $pagina,
        'qtdPorPagina'  => $qtdPorPagina
    );
    
    if(!empty($nome)){
        $parametros['nome'] = $nome;
    }    
    
    $Paginacao = new Paginacao(array_merge(
        $clientes['paginacao'], 
        array(
            'parametros' => $parametros,
            'rota' => 'lista_clientes'
        )
    ));
    
    $app->render('clientes/consultar.html.twig', array(
        'menuPrincipal'         => 'cadastro_clientes',
        'user' 			=> $u,
        'clientes'                 => $clientes['registros'],
        'paginacao'             => $Paginacao,
        'filtro'                => array(
            'nome'  => $nome
        )
    ));
})
->name('lista_clientes');



$app->get('/admin/dashboard', function() use($app){
	$u = WebUser::getInstance();	
	
	$app->render('admin/dashboard.html.twig', array(
		'menuPrincipal' => 'dashboard',
		'user'			=> $u
	));
})
->name('dashboard_admin');