<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

/**
 * Tela de novo atendimento
 */
$app->get('/atendimentos/novo', function() use($app) {

    $u = WebUser::getInstance();

    $C = new Clientes();
    $clientes = $C->getListaClientes(array(
        'usuario' => $u->getUsuario(),
        'text' => '%',
        'pagina' => 1,
        'qtdPorPagina' => 100
    ));

    $A = new Areas();
    $areas = $A->getListaAreas(array(
        'usuario' => $u->getUsuario(),        
    ));
	
	$T = new TiposAtendimento();
	$tipos = $T->getListaTipoAtendimentos();

    $app->render('atendimento/novo.html.twig', array(
        'menuPrincipal' => 'registrar_atendimento',
        'user'          => $u,
        'areas'         => $areas['registros'],
        'clientes'      => $clientes['registros'],
		'tipos'			=> $tipos['registros']
    ));
})
->name('novo_atendimento');

/**
 * Ação para salvar um novo atendimento
 */
$app->post('/atendimentos/salvar', function() use($app) {

    $u = WebUser::getInstance();

    if($u->isCliente() == false){
        # Consulta o cliente recebido
        $C = new Clientes();
        $cliente = $C->getCliente(array(
            'id'        => $app->request->post('cliente'),
            'usuario'   => $u->getUsuario()
        ));        
    }
    else {
        $cliente = $u->getUsuario();
    }
	
    $Atendimentos = new Atendimentos();

    # Consulta a area recebida
    $A = new Areas();
    
    if($u->isCliente() == false){
        $area = $A->getArea(array(
            'usuario'   => $u->getUsuario(),
            'id'        => $app->request->post('area')
        ));
    }
    else {
        $area = $A->getArea(array(
            'usuario'   => $u->getUsuario(),
            'nome'      => 'Suporte'
        ));
    }
	
    $T = new TiposAtendimento();
    $tipo = $T->getTipoAtendimento(array(		
        'id' => $app->request->post('tipo')
    ));	

    $status = $Atendimentos->getStatus(array(
        'usuario' 	=> $u->getUsuario(),
        'nome'	=> StatusAtendimento::STATUS_ABERTO
    ));
	
    # Cria o atendimento
    $a = new Atendimento();
    $a->setTipo($tipo);
    $a->setEmpresa($u->getUsuario()->getEmpresa());    
    $a->setCliente($cliente);
    $a->setAtendente(null);
    $a->setArea($area);
    $a->setStatus($status);
    $a->setTitulo($app->request->post('titulo'));
    $a->setDescricao($app->request->post('descricao'));
    $a->setDataCriacao(new DateTime());
    $a->setCriadoPor($u->getUsuario()->getNome());
    
    $a = $Atendimentos->salvar($a);
    
    $app->redirect($app->urlFor('ver_atendimento', array('id' => $a->getId())));
})
->name('salvar_atendimento');


$app->get('/atendimentos/:id', function($id) use($app) {
    $u = WebUser::getInstance();

    $A = new Atendimentos();
    $atendimento = $A->getAtendimento(array(
        'usuario' => $u->getUsuario(),
        'id' => $id
    ));
	
    $Areas = new Areas();
    $listaAreas = $Areas->getListaAreas(array(
        'usuario' => $u->getUsuario(),
        'pagina' => 1,
        'qtdPorPagina' => 100
    ));
    
    
    $ACL = SacACL::getInstance();
    $permissoes = array(
        'atendimento_comentar'      => $ACL->isAllowed($u->getUsuario(), $atendimento, SacACL::ATENDIMENTO_COMENTAR),
        'atendimento_encaminhar'    => $ACL->isAllowed($u->getUsuario(), $atendimento, SacACL::ATENDIMENTO_ENCAMINHAR),
        'atendimento_concluir'      => $ACL->isAllowed($u->getUsuario(), $atendimento, SacACL::ATENDIMENTO_CONCLUIR)
    );
    
    $app->render('atendimento/ver.html.twig', array(
        'menuPrincipal' => 'consultar_atendimento',
        'user' 		=> $u,
        'atendimento' 	=> $atendimento,
        'areas'		=> $listaAreas['registros'],
        'permissoes'    => $permissoes
    ));
})
->name('ver_atendimento');


$app->get('/atendimentos/:id/realizar', function($id) use($app) {
            $u = WebUser::getInstance();

            $A = new Atendimentos();
            $atendimento = $A->getAtendimento(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $app->render('atendimento/resolucao.html.twig', array(
                'menuPrincipal' => 'consultar_atendimento',
                'user' => $u,
                'atendimento' => $atendimento
            ));
        })
        ->name('resolucao_atendimento');


$app->get('/atendimentos/:id/encaminhar', function($id) use($app) {
            $u = WebUser::getInstance();

            $A = new Atendimentos();
            $atendimento = $A->getAtendimento(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $A2 = new Areas();
            $areas = $A2->getListaAreas(array(
                'usuario' => $u->getUsuario(),
                'pagina' => 0,
                'qtdPorPagina' => 100
            ));

            $app->render('atendimento/encaminhar.html.twig', array(
                'menuPrincipal' => 'consultar_atendimento',
                'user' => $u,
                'atendimento' => $atendimento,
                'areas' => $areas['registros']
            ));
        })
        ->name('encaminhar_atendimento');


$app->post('/atendimentos/:atendimentoId/cadastrar-comentario', function($atendimentoId) use($app) {
            $u = WebUser::getInstance();
			
            $A = new Atendimentos();
            $atendimento = $A->getAtendimento(array(
                    'usuario' => $u->getUsuario(),
                    'id' => $atendimentoId
            ));

            $C = new ComentarioAtendimento();
            $C->setEmpresa($u->getUsuario()->getEmpresa());
            $C->setAtendimento($atendimento);
            $C->setUsuario($u->getUsuario());
            $C->setDataCriacao(new DateTime());
            $C->setDescricao($app->request->post('comentario'));
            $C->setPublico($app->request->post('comentario_publico') == 1 ? true : false);

            $A->salvarComentario($C);
            
            $app->flash('sucesso', 'Comentário adicionado com sucesso');

            $app->redirectTo('ver_atendimento', array('id' => $atendimentoId));
        })
        ->name('cadastrar_comentario_atendimento');

$app->post('/atendimentos/:atendimentoId/fazer-encaminhamento', function($atendimentoId) use($app) {
    $u = WebUser::getInstance();

    $A = new Atendimentos();

    // Consulta o atendimento
    $atendimento = $A->getAtendimento(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $atendimentoId
    ));

    
    if($app->request->post('area_id') == 'responsavel_area'){
        $novoStatus = $A->getStatus(array(
            'usuario'   => $u->getUsuario(),
            'nome'      => StatusAtendimento::STATUS_ANALISE_AREA
        ));
        $atendimento->setStatus($novoStatus);
    }
    else {
        $Areas = new Areas();

        // Consulta a nova area
        $area = $Areas->getArea(array(
            'usuario' => $u->getUsuario(),
            'id'        => $app->request->post('area_id')
        ));
        
        // Define a nova area do atendimento
        $atendimento->setArea($area);
    }
    
    $atendimento->setDataAlteracao(new DateTime());
    $A->atualizar($atendimento);

    $app->flash('sucesso', 'Atendimento encaminhado com sucesso!');
    $app->redirectTo('ver_atendimento', array('id' => $atendimentoId));
})
->name('fazer_encaminhamento_atendimento');



$app->post('/atendimentos/:atendimentoId/cadastrar-conclusao', function($atendimentoId) use($app) {
    $u = WebUser::getInstance();
    
    $A = new Atendimentos();

    // Consulta o atendimento
    $atendimento = $A->getAtendimento(array(
        'usuario'   => $u->getUsuario(),
        'id'        => $atendimentoId
    ));
    
    $status = $A->getStatus(array(
        'usuario'   => $u->getUsuario(),
        'nome'      => StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO
    ));
    
    // Define a conclusão
    $atendimento->setStatus($status);
    $atendimento->setConclusao($app->request->post('conclusao'));
    $atendimento->setDataAlteracao(new DateTime());
    $atendimento->setDataConclusao(new DateTime());

    $A->atualizar($atendimento);

    $app->flash('sucesso', 'Atendimento concluído com sucesso!');

    $app->redirectTo('ver_atendimento', array('id' => $atendimentoId));
})
->name('cadastrar_conclusao_atendimento');


/**
 * Tela de consulta de atendimentos
 */
$app->get('/atendimentos(/:pagina(/:qtdPorPagina(/:numero(/:documento(/:cliente)))))', 
function($pagina=1, $qtdPorPagina=20, $numero='', $documento='', $cliente='') use($app) {

    $user = WebUser::getInstance();

    $A = new Atendimentos();

    if($user->isUsuario()){
        $pListaAtendimentos = array(
            'usuario'       => $user->getUsuario(),
            'pagina'        => $pagina,
            'qtdPorPagina'  => $qtdPorPagina,
            'cliente'       => $cliente,
            'numero'        => $numero
        );
    }
    // Se for cliente
    else {
        $pListaAtendimentos = array(
            'empresa'       => $user->getUsuario()->getEmpresa(),
            'cliente'       => $user->getUsuario(),
            'pagina'        => $pagina,
            'qtdPorPagina'  => $qtdPorPagina
        );
    }
    
    $parametros = array();
    
    if(!empty($numero) && $numero != '-'){
        $parametros['numero'] = $numero;
    }
    
    if(!empty($documento) && $documento != '-'){
        $parametros['documento'] = $documento;
    }
    
    if(!empty($cliente) && $cliente != '-'){
        $parametros['cliente'] = $cliente;
    }

    $atendimentos = $A->getListaAtendimentos($pListaAtendimentos);

    $Paginacao = new Paginacao(array_merge(
        $atendimentos['paginacao'], 
        array(
            'parametros' => $parametros,
            'rota' => 'consultar_atendimento'
        )
    ));
    
    $app->render('atendimento/consultar.html.twig', array(
        'menuPrincipal' => 'consultar_atendimento',
        'atendimentos'  => $atendimentos['registros'],
        'user'          => $user,
        'paginacao'     => $Paginacao,
        'parametros'    => $parametros
    ));
})
->name('consultar_atendimento');
