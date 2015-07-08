<?php

$app->get('/:permalink', function($permalink) use($app){
    
    $E = new Empresas();
    $Empresa = $E->getLista(array(
        'permalink'     => $permalink,
        'pagina'        => 1,
        'qtdPorPagina'  => 1
    ));        
    
    $app->render('empresas/login.html.twig', array(
        'empresa' => $Empresa['registros'][0]
    ));
})
->name('login_empresa');

$app->get('/admin/configuracoes/dados-empresa', function() use($app){
    
    $u = WebUser::getInstance();
    
    $app->render('admin/dados_empresa.html.twig', array(
        'menuPrincipal' => 'configuracoes',
        'user'          => $u,
        'empresa'       => $u->getUsuario()->getEmpresa()
    ));
})
->name('dados_empresa');


$app->post('/admin/empresas/enviar-logo', function() use($app){
    $H = new UploadHandler();
})
->name("enviar_logo_empresa");

/**
 * Tela de novo empresa
 */
$app->get('/admin/empresas/novo', function() use($app){    

    $u = WebUser::getInstance();
    
    $E = new Empresas();
    
    $app->render('empresas/novo.html.twig', array(
        'menuPrincipal' => 'cadastro_empresa',
        'user' 		=> $u
    ));
})
->name('novo_empresa');


$app->post('/admin/empresas/salvar', function() use($app){    

    $u = WebUser::getInstance();    
	
    // Consulta a area
    $A = new Areas();
    $Area = $A->getArea(array(
        'empresa' => $u->getUsuario(),
        'id' => $app->request->post('area')
    ));

    // Consulta o cargo
    $C = new Cargos();
    $Cargo = $C->getCargo(array(
        'empresa' => $u->getUsuario(),
        'id' => $app->request->post('cargo')
    ));
    
    // Classe que persiste o empresa
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
    
    $app->redirectTo('ver_empresa', array(
        'id' => $Usuario->getId()
    ));
})
->name('salvar_empresa');


$app->post('/admin/empresas/atualizar', function() use($app){    

    $u = WebUser::getInstance();    
	
    $E = new Empresas();
    $Empresa = $E->getEmpresa(array('id' => $app->request->post('id')));
    
    if($Empresa instanceof Empresa){                
        $Empresa->setNomeFantasia($app->request->post('nome_fantasia'));
        $Empresa->setRazaoSocial($app->request->post('razao_social'));
        $Empresa->setCnpj($app->request->post('cnpj'));
        $Empresa->setCep($app->request->post('cep'));
        $Empresa->setEndereco($app->request->post('endereco'));
        $Empresa->setBairro($app->request->post('bairro'));
        $Empresa->setCidade($app->request->post('cidade'));
        $Empresa->setEstado($app->request->post('estado'));        
        $Empresa->setDddTelefone($app->request->post('ddd_telefone'));
        $Empresa->setTelefone($app->request->post('telefone'));     
        
        if($app->request->post('nome_arquivo') != '' && $app->request->post('mimetype') != ''){            
            $arquivo = Config::$uploadPath.$app->request->post('nome_arquivo');
            if(file_exists($arquivo)){                                
                $Empresa->setLogo($app->request->post('nome_arquivo'));                
            }
        }
        
        $E->salvar($Empresa);        
        $app->flash('sucesso', 'Empresa atualizada com sucesso!');
    
        $app->redirectTo('ver_empresa', array(
            'id' => $Empresa->getId()
        ));
    }
    else {
        $app->flash('erro', 'Empresa não encontrada');
        
        $app->redirectTo('lista_empresas');
    }
})
->name('atualizar_empresa');

$app->get('/admin/empresas/:id/editar', function($id) use($app){    

    $u = WebUser::getInstance();    
    
    $U = new Empresas();
    $empresa = $U->getEmpresa(array( 'id' => $id ));       
    
    $app->render('empresas/editar.html.twig', array(
        'menuPrincipal' => 'cadastro_empresa',
        'empresa'       => $empresa,
        'user'          => $u
    ));
})
->name('editar_empresa');

$app->get('/admin/empresas/:id', function($id) use($app){    

    $u = WebUser::getInstance();
    
    
    $U = new Empresas();
    $empresa = $U->getEmpresa(array( 'id' => $id ));
    
    $tipoUsuarios = array(
        'atendente'         => 0,
        'administrador'     => 0,
        'responsavel_area'  => 0
    );
    
    $usuarios = $empresa->getUsuarios();
    foreach($usuarios as $usuario){
        $tipoUsuarios[$usuario->getCargo()->getNome()]++;
    }
    
    $qtdAreas = count($empresa->getAreas());
    
    $app->render('empresas/ver.html.twig', array(
        'menuPrincipal' => 'cadastro_empresa',
        'empresa'       => $empresa,
        'user'          => $u,
        'tipoUsuarios'  => $tipoUsuarios,
        'qtdAreas'      => $qtdAreas
    ));
})
->name('ver_empresa');


/**
 * Tela de listagem de empresas
 */
$app->get('/admin/empresas(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina=1, $qtdPorPagina=20, $nome='') use($app){    

    $u = WebUser::getInstance();
    
    $U = new Empresas();
    $listaEmpresas = $U->getLista(array(        
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
        $listaEmpresas['paginacao'], 
        array(
            'parametros' => $parametros,
            'rota' => 'lista_empresas'
        )
    ));
    
    $app->render('empresas/consultar.html.twig', array(
        'menuPrincipal'         => 'cadastro_empresa',
        'user' 			=> $u,
        'empresas'              => $listaEmpresas['registros'],
        'paginacao'             => $Paginacao,
        'filtro'                => array(
            'nome'  => $nome
        )
    ));
})
->name('lista_empresas');