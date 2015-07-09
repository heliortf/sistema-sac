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
    
    $E = new Empresas();    
                  
    $Empresa = new Empresa();
    $Empresa->setNomeFantasia($app->request->post('nome_fantasia'));
    $Empresa->setRazaoSocial($app->request->post('razao_social'));
    $Empresa->setPermalink($app->request->post('permalink'));
    $Empresa->setCnpj($app->request->post('cnpj'));
    $Empresa->setCep($app->request->post('cep'));
    $Empresa->setEndereco($app->request->post('endereco'));
    $Empresa->setBairro($app->request->post('bairro'));
    $Empresa->setCidade($app->request->post('cidade'));
    $Empresa->setEstado($app->request->post('estado'));        
    $Empresa->setEmail($app->request->post('email'));
    $Empresa->setDddTelefone($app->request->post('ddd_telefone'));
    $Empresa->setTelefone($app->request->post('telefone'));     

    $E->salvar($Empresa);        
    
    
    $em = Conexao::getEntityManager();

    // Cadastra o cargo
    $C = new Cargo();
    $C->setNome(Cargo::ATENDENTE);
    $C->setEmpresa($Empresa);

    $C2 = new Cargo();
    $C2->setNome(Cargo::ADMINISTRADOR);
    $C2->setEmpresa($Empresa);

    $C3 = new Cargo();
    $C3->setNome(Cargo::RESPONSAVEL_AREA);
    $C3->setEmpresa($Empresa);

    $em->persist($C);
    $em->persist($C2);
    $em->persist($C3);
    $em->flush();

    // Cadastra a área
    $A = new Area();
    $A->setEmpresa($Empresa);
    $A->setNome("Suporte");

    $A2 = new Area();
    $A2->setEmpresa($Empresa);
    $A2->setNome("Diretoria");

    $em->persist($A);
    $em->persist($A2);
    $em->flush();
    
    
    $U = new Usuarios();
    
    $Usuario = new Usuario();
    $Usuario->setNome($app->request->post('nome_responsavel'));
    $Usuario->setCpf($app->request->post('cpf'));
    $Usuario->setEmail($app->request->post('email_responsavel'));
    $Usuario->setSenha($app->request->post('senha'));
    $Usuario->setLogin($app->request->post('login'));
    $Usuario->setEmpresa($Empresa);
    $Usuario->setCargo($C2);
    $Usuario->setArea($A2);
    
    $U->salvar($Usuario);
    
    $app->flash('sucesso', 'Empresa registrada com sucesso!');
    $app->redirectTo('ver_empresa', array( 'id' => $Empresa->getId() ));
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
        $Empresa->setEmail($app->request->post('email'));
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
        
        $U = new Usuarios();
        $Usuario = $U->getUsuario(array('id' => $app->request->post('usuarioid')));
        
        if($Usuario instanceof Usuario){
            
            $Usuario->setNome($app->request->post('nome_responsavel'));
            $Usuario->setCpf($app->request->post('cpf'));
            $Usuario->setEmail($app->request->post('email_responsavel'));
            $Usuario->setSenha($app->request->post('senha'));
            $Usuario->setLogin($app->request->post('login'));
            
            $U->salvar($Usuario);
        }
    
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