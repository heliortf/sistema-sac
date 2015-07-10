<?php

use Slim\Slim;

/**
 * @var Slim
 */
global $app;

$app->post('/do-search', function() use($app) {
            $p = $app->request->post('p');
            foreach ($p as $k => $v) {
                if ($v == '') {
                    unset($p[$k]);
                }
            }
            $app->redirectTo($app->request->post('rota'), $p);
        })
        ->name('buscar');

$app->get('/admin/configuracoes', function() use($app) {
            $user = WebUser::getInstance();

            $app->render('admin/configuracoes.html.twig', array(
                'user' => $user
            ));
        })
        ->name('configuracoes');

/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios', function() use($app) {

            $user = WebUser::getInstance();

//    echo "<pre>"; print_r($atendimentos); echo "</pre>";

            $app->render('relatorios/consultar.html.twig', array(
                'menuPrincipal' => 'relatorios_gerenciais',
                'user' => $user
            ));
        })
        ->name('relatorios_gerenciais_admin');

/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios/atendimentos-resolvidos', function() use($app) {

            $user = WebUser::getInstance();
            $R = new Relatorios();
            
            $atendimentos = $R->getAtendimentosResolvidos(array(
                'empresa' => $user->getUsuario()->getEmpresa()
            ));

            $app->render('relatorios/atendimentos_resolvidos.html.twig', array(
                'menuPrincipal' => 'relatorios_gerenciais',
                'atendimentos' => $atendimentos,
                'user' => $user,
                'paginacao' => array(
                    'inicio' => 0,
                    'fim' => 3,
                    'qtdRegistros' => 3
                )
            ));
        })
        ->name('relatorio_atendimentos_resolvidos');
        
/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios/avaliacao-funcionarios', function() use($app) {

            $user = WebUser::getInstance();

//    echo "<pre>"; print_r($atendimentos); echo "</pre>";

            $app->render('relatorios/avaliacao_funcionarios.html.twig', array(
                'menuPrincipal' => 'relatorios_gerenciais',
                'user' => $user,
                'paginacao' => array(
                    'inicio' => 0,
                    'fim' => 3,
                    'qtdRegistros' => 3
                )
            ));
        })
        ->name('relatorio_avaliacao_funcionarios');

/**
 * Tela de consulta de atendimentos
 */
$app->get('/admin/relatorios/satisfacao-clientes', function() use($app) {

            $user = WebUser::getInstance();

//    echo "<pre>"; print_r($atendimentos); echo "</pre>";
            $R = new Relatorios();
            $clientes = $R->getSatisfacaoClientes(array(
                'empresa' => $user->getUsuario()->getEmpresa()
            ));            
            
            $app->render('relatorios/satisfacao_clientes.html.twig', array(
                'menuPrincipal' => 'relatorios_gerenciais',
                'user' => $user,
                'clientes'  => $clientes,
                'paginacao' => array(
                    'inicio' => 0,
                    'fim' => 3,
                    'qtdRegistros' => 3
                )
            ));
        })
        ->name('relatorio_satisfacao_clientes');

/**
 * Tela de novo usuario
 */
$app->get('/admin/usuarios/novo', function() use($app) {

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
                'user' => $u,
                'areas' => $areas['registros'],
                'cargos' => $cargos['registros']
            ));
        })
        ->name('novo_usuario');


$app->post('/admin/usuarios/salvar', function() use($app) {

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


$app->post('/admin/usuarios/atualizar', function() use($app) {

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
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('id')
            ));

            if ($Usuario instanceof Usuario) {
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
            } else {
                $app->flash('erro', 'Usuário não encontrado');

                $app->redirectTo('lista_usuarios');
            }
        })
        ->name('atualizar_usuario');


$app->get('/admin/usuarios/:id/editar', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Usuarios();
            $usuario = $U->getUsuario(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
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
                'usuario' => $usuario,
                'areas' => $areas['registros'],
                'cargos' => $cargos['registros'],
                'user' => $u
            ));
        })
        ->name('editar_usuario');


$app->get('/admin/usuarios/:id', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Usuarios();
            $usuario = $U->getUsuario(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $app->render('usuarios/ver.html.twig', array(
                'menuPrincipal' => 'cadastro_usuario',
                'usuario' => $usuario,
                'user' => $u
            ));
        })
        ->name('ver_usuario');


/**
 * Tela de listagem de usuarios
 */
$app->get('/admin/usuarios(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina = 1, $qtdPorPagina = 20, $nome = '') use($app) {

            $u = WebUser::getInstance();

            $U = new Usuarios();
            $listaUsuarios = $U->getLista(array(
                'usuario' => $u->getUsuario(),
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina,
                'nome' => "%" . $nome . "%"
            ));

            $parametros = array(
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            );

            if (!empty($nome)) {
                $parametros['nome'] = $nome;
            }
            $Paginacao = new Paginacao(array_merge(
                            $listaUsuarios['paginacao'], array(
                        'parametros' => $parametros,
                        'rota' => 'lista_usuarios'
                            )
            ));

            $app->render('usuarios/consultar.html.twig', array(
                'menuPrincipal' => 'cadastro_usuario',
                'user' => $u,
                'usuarios' => $listaUsuarios['registros'],
                'paginacao' => $Paginacao,
                'filtro' => array(
                    'nome' => $nome
                )
            ));
        })
        ->name('lista_usuarios');


/**
 * Tela de nova area
 */
$app->get('/admin/areas/nova', function() use($app) {
            $u = WebUser::getInstance();

            $app->render('areas/nova.html.twig', array(
                'menuPrincipal' => 'cadastro_areas',
                'user' => $u
            ));
        })
        ->name('nova_area');


$app->post('/admin/areas/salvar', function() use($app) {

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


$app->post('/admin/areas/atualizar', function() use($app) {

            $u = WebUser::getInstance();

            // Consulta a area
            $A = new Areas();
            $Area = $A->getArea(array(
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('id')
            ));

            if ($Area instanceof Area) {
                $Area->setNome($app->request->post('nome'));
                $A->salvar($Area);

                $app->flash('sucesso', 'Área atualizada com sucesso!');
                $app->redirectTo('ver_area', array(
                    'id' => $Area->getId()
                ));
            } else {
                $app->flash('erro', 'Área não encontrada');
                $app->redirectTo('lista_areas');
            }
        })
        ->name('atualizar_area');


$app->get('/admin/areas/:id/editar', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Areas();
            $area = $U->getArea(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $app->render('areas/editar.html.twig', array(
                'menuPrincipal' => 'cadastro_area',
                'area' => $area,
                'user' => $u
            ));
        })
        ->name('editar_area');


$app->get('/admin/areas/:id', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Areas();
            $area = $U->getArea(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $Usuarios = new Usuarios();
            $usuarios = $Usuarios->getLista(array(
                'usuario' => $u->getUsuario(),
                'area' => $id,
                'pagina' => 1,
                'qtdPorPagina' => 100
            ));

            $app->render('areas/ver.html.twig', array(
                'menuPrincipal' => 'cadastro_area',
                'area' => $area,
                'user' => $u,
                'usuarios' => $usuarios['registros']
            ));
        })
        ->name('ver_area');


/**
 * Listagem de áreas
 */
$app->get('/admin/areas(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina = 1, $qtdPorPagina = 20, $nome = '') use($app) {
            $u = WebUser::getInstance();

            $A = new Areas();
            $areas = $A->getListaAreas(array(
                'usuario' => $u->getUsuario(),
                'nome' => (!empty($nome) ? "%$nome%" : ""),
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            ));


            $parametros = array(
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            );

            if (!empty($nome)) {
                $parametros['nome'] = $nome;
            }

            $Paginacao = new Paginacao(array_merge(
                            $areas['paginacao'], array(
                        'parametros' => $parametros,
                        'rota' => 'lista_areas'
                            )
            ));

            $app->render('areas/consultar.html.twig', array(
                'menuPrincipal' => 'cadastro_areas',
                'user' => $u,
                'areas' => $areas['registros'],
                'paginacao' => $Paginacao,
                'filtro' => array(
                    'nome' => $nome
                )
            ));
        })
        ->name('lista_areas');


/**
 * Tela de nova cliente
 */
$app->get('/admin/clientes/novo', function() use($app) {
            $u = WebUser::getInstance();

            $estados = array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");

            $app->render('clientes/novo.html.twig', array(
                'menuPrincipal' => 'cadastro_clientes',
                'user' => $u,
                'estados' => $estados
            ));
        })
        ->name('novo_cliente');


$app->post('/admin/clientes/salvar', function() use($app) {

            $u = WebUser::getInstance();

            // Classe que persiste o usuario
            $A = new Clientes();

            // Cliente
            $Cliente = new Cliente();
            $Cliente->setEmpresa($u->getUsuario()->getEmpresa());
            $Cliente->setNome($app->request->post('nome'));
            $Cliente->setEndereco($app->request->post('endereco'));
            $Cliente->setNumero($app->request->post('numero'));
            $Cliente->setBairro($app->request->post('bairro'));
            $Cliente->setCidade($app->request->post('cidade'));
            $Cliente->setEstado($app->request->post('estado'));
            $Cliente->setCep($app->request->post('cep'));
            $Cliente->setCpf($app->request->post('cpf'));
            $Cliente->setCnpj($app->request->post('cnpj'));
            $Cliente->setEmail($app->request->post('email'));
            $Cliente->setDddTelefone($app->request->post('ddd_telefone'));
            $Cliente->setTelefone($app->request->post('telefone'));
            $Cliente->setDddCelular($app->request->post('ddd_celular'));
            $Cliente->setCelular($app->request->post('celular'));
            $Cliente->setLogin($app->request->post('login'));
            $Cliente->setSenha($app->request->post('senha'));
            $Cliente->setDataCriacao(new DateTime());

            $A->salvar($Cliente);

            $app->redirectTo('ver_cliente', array(
                'id' => $Cliente->getId()
            ));
        })
        ->name('salvar_cliente');


$app->post('/admin/clientes/excluir', function() use($app) {

            $u = WebUser::getInstance();

            // Classe que persiste o usuario
            $C = new Clientes();

            // Cliente
            $Cliente = $C->getCliente(array(
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('id')
            ));

            if ($Cliente instanceof Cliente) {
                $C->excluir($Cliente);

                $app->flash('successo', 'Cliente excluído com sucesso!');
                $app->redirectTo('lista_clientes');
            } else {
                $app->flash('erro', 'Cliente não encontrado!');
                $app->redirectTo('ver_cliente', array(
                    'id' => $Cliente->getId()
                ));
            }
        })
        ->name('excluir_cliente');


$app->get('/admin/clientes/importar', function() use($app) {

            $u = WebUser::getInstance();

            $app->render('clientes/importar.html.twig', array(
                'menuPrincipal' => 'cadastro_cliente',
                'user' => $u
            ));
        })
        ->name('importar_clientes');

$app->post('/admin/clientes/confirmar-importacao', function() use($app) {

            if (!empty($_FILES['files']['name'])) {
                $arquivo_csv = Config::$uploadCSVPath . 'csv_' . rand(100000, 999999) . '.csv';
                $moveu = move_uploaded_file($_FILES['files']['tmp_name'], $arquivo_csv);

                $csv = new parseCSV();
                $csv->delimiter = ",";
                $csv->input_encoding = "UTF-8";
                $csv->parse($arquivo_csv);

                $camposCSV = $csv->titles;
                $camposImportacao = array(
                    'nome' => 'Nome',
                    'cpf' => 'CPF',
                    'cnpj' => 'CNPJ',
                    'endereco' => 'Endereço',
                    'bairro' => 'Bairro',
                    'cidade' => 'Cidade',
                    'estado' => 'Estado',
                    'cep' => 'CEP',
                    'email' => 'E-mail',
                    'login' => 'Login',
                    'senha' => 'Senha'
                );

                $camposCombinaveis = array(
                    'nome', 'endereco'
                );

                $camposObrigatorios = array(
                    'nome'
                );

                $camposDigitaveis = array(
                );

                if ($moveu) {
                    $u = WebUser::getInstance();

                    $app->render('clientes/confirmar-importacao.html.twig', array(
                        'arquivoCSV' => $arquivo_csv,
                        'camposCSV' => $camposCSV,
                        'camposImportacao' => $camposImportacao,
                        'camposCombinaveis' => $camposCombinaveis,
                        'camposObrigatorios' => $camposObrigatorios,
                        'camposDigitaveis' => $camposDigitaveis,
                        'menuPrincipal' => 'cadastro_cliente',
                        'user' => $u
                    ));
                } else {
                    $app->flash('erro', 'Não foi possível enviar o arquivo CSV');
                    $app->redirectTo('importar_clientes');
                }
            } else {
                $app->flash('erro', 'Escolha um arquivo CSV');
                $app->redirectTo('importar_clientes');
            }
        })
        ->name('confirmar_importacao_clientes');


$app->post('/admin/clientes/realizar-importacao', function() use($app) {
            $u = WebUser::getInstance();

            $arquivo = $app->request->post('arquivo_csv');

            $p = new parseCSV();
            $p->delimiter = ",";
            $p->input_encoding = "UTF-8";
            $p->parse($arquivo);

            $getValorCSV = function($dados, $campos) {
                $valores = array();
                foreach ($campos as $campoCSV) {
                    if (!empty($campoCSV)) {
                        $valores[] = $dados[$campoCSV];
                    }
                }

                return count($valores) > 0 ? implode(" ", $valores) : "";
            };

            $em = Conexao::getEntityManager();

            foreach ($p->data as $cliente) {
                $C = new Cliente();
                $C->setEmpresa($u->getUsuario()->getEmpresa());
                $C->setNome($getValorCSV($cliente, $app->request->post('nome')));
                $C->setEndereco($getValorCSV($cliente, $app->request->post('endereco')));
                $C->setBairro($getValorCSV($cliente, $app->request->post('bairro')));
                $C->setCidade($getValorCSV($cliente, $app->request->post('cidade')));
                $C->setEstado($getValorCSV($cliente, $app->request->post('estado')));
                $C->setCep($getValorCSV($cliente, $app->request->post('cep')));
                $C->setCpf($getValorCSV($cliente, $app->request->post('cpf')));
                $C->setCnpj($getValorCSV($cliente, $app->request->post('cnpj')));
                $C->setDataCriacao(new DateTime());
                $C->setEmail($getValorCSV($cliente, $app->request->post('email')));
                $C->setLogin($getValorCSV($cliente, $app->request->post('login')));
                $C->setSenha($getValorCSV($cliente, $app->request->post('senha')));

                $em->persist($C);
            }

            $em->flush();

            @unlink($arquivo);

            $app->flash('sucesso', 'Clientes importados com sucesso!');
            $app->redirectTo('sucesso_importacao_clientes', array('qtd' => count($p->data)));
        })
        ->name('realizar_importacao_clientes');



$app->get('/admin/clientes/sucesso-importacao/:qtd', function($qtd) use($app) {

            $u = WebUser::getInstance();

            $app->render('clientes/importacao-sucesso.html.twig', array(
                'menuPrincipal' => 'cadastro_cliente',
                'qtd' => $qtd,
                'user' => $u
            ));
        })
        ->name('sucesso_importacao_clientes');


$app->get('/admin/clientes/erro-importacao', function() use($app) {

            $u = WebUser::getInstance();

            $app->render('clientes/importacao-erro.html.twig', array(
                'menuPrincipal' => 'cadastro_cliente',
                'user' => $u
            ));
        })
        ->name('erro_importacao_clientes');



$app->post('/admin/clientes/atualizar', function() use($app) {

            $u = WebUser::getInstance();

            // Consulta a cliente
            $A = new Clientes();
            $Cliente = $A->getCliente(array(
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('id')
            ));

            if ($Cliente instanceof Cliente) {
                $Cliente->setNome($app->request->post('nome'));
                $Cliente->setEndereco($app->request->post('endereco'));
                $Cliente->setNumero($app->request->post('numero'));
                $Cliente->setBairro($app->request->post('bairro'));
                $Cliente->setCidade($app->request->post('cidade'));
                $Cliente->setEstado($app->request->post('estado'));
                $Cliente->setCep($app->request->post('cep'));
                $Cliente->setCpf($app->request->post('cpf'));
                $Cliente->setCnpj($app->request->post('cnpj'));
                $Cliente->setEmail($app->request->post('email'));
                $Cliente->setSenha($app->request->post('senha'));
                $Cliente->setDddTelefone($app->request->post('ddd_telefone'));
                $Cliente->setTelefone($app->request->post('telefone'));
                $Cliente->setDddCelular($app->request->post('ddd_celular'));
                $Cliente->setCelular($app->request->post('celular'));
                $Cliente->setDataAlteracao(new DateTime());
                $A->salvar($Cliente);

                $app->flash('sucesso', 'Cliente atualizado com sucesso!');
                $app->redirectTo('ver_cliente', array(
                    'id' => $Cliente->getId()
                ));
            } else {
                $app->flash('erro', 'Cliente não encontrado');
                $app->redirectTo('lista_clientes');
            }
        })
        ->name('atualizar_cliente');


$app->get('/admin/clientes/:id/editar', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Clientes();
            $cliente = $U->getCliente(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $estados = array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");

            $app->render('clientes/editar.html.twig', array(
                'menuPrincipal' => 'cadastro_cliente',
                'cliente' => $cliente,
                'estados' => $estados,
                'user' => $u
            ));
        })
        ->name('editar_cliente');

$app->get('/admin/clientes/:id', function($id) use($app) {

            $u = WebUser::getInstance();


            $U = new Clientes();
            $cliente = $U->getCliente(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));

            $estados = array("AC" => "Acre", "AL" => "Alagoas", "AM" => "Amazonas", "AP" => "Amapá", "BA" => "Bahia", "CE" => "Ceará", "DF" => "Distrito Federal", "ES" => "Espírito Santo", "GO" => "Goiás", "MA" => "Maranhão", "MT" => "Mato Grosso", "MS" => "Mato Grosso do Sul", "MG" => "Minas Gerais", "PA" => "Pará", "PB" => "Paraíba", "PR" => "Paraná", "PE" => "Pernambuco", "PI" => "Piauí", "RJ" => "Rio de Janeiro", "RN" => "Rio Grande do Norte", "RO" => "Rondônia", "RS" => "Rio Grande do Sul", "RR" => "Roraima", "SC" => "Santa Catarina", "SE" => "Sergipe", "SP" => "São Paulo", "TO" => "Tocantins");

            $app->render('clientes/ver.html.twig', array(
                'menuPrincipal' => 'cadastro_cliente',
                'cliente' => $cliente,
                'user' => $u,
                'estados' => $estados
            ));
        })
        ->name('ver_cliente')
        ->conditions(array('id' => '[0-9]{1,}'));


/**
 * Listagem de áreas
 */
$app->get('/admin/clientes(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina = 1, $qtdPorPagina = 20, $nome = '') use($app) {
            $u = WebUser::getInstance();

            $A = new Clientes();
            $clientes = $A->getListaClientes(array(
                'usuario' => $u->getUsuario(),
                'nome' => (!empty($nome) ? "%$nome%" : ""),
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            ));


            $parametros = array(
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            );

            if (!empty($nome)) {
                $parametros['nome'] = $nome;
            }

            $Paginacao = new Paginacao(array_merge(
                            $clientes['paginacao'], array(
                        'parametros' => $parametros,
                        'rota' => 'lista_clientes'
                            )
            ));

            $app->render('clientes/consultar.html.twig', array(
                'menuPrincipal' => 'cadastro_clientes',
                'user' => $u,
                'clientes' => $clientes['registros'],
                'paginacao' => $Paginacao,
                'filtro' => array(
                    'nome' => $nome
                )
            ));
        })
        ->name('lista_clientes');



/**
 * Tela de nova cliente
 */
$app->get('/admin/pedidos/novo', function() use($app) {
            $u = WebUser::getInstance();
            
            $C = new Clientes();
            $clientes = $C->getListaClientes(array(
                'usuario'       => $u,
                'pagina'        => 1,
                'qtdPorPagina'  => 400
            ));

            $app->render('pedidos/novo.html.twig', array(
                'menuPrincipal' => 'cadastro_pedidos',
                'user'          => $u,
                'clientes'      => $clientes['registros']
            ));
        })
        ->name('novo_pedido');


$app->post('/admin/pedidos/salvar', function() use($app) {

            $u = WebUser::getInstance();

            // Classe que persiste o usuario
            $C = new Clientes();
            $cliente = $C->getCliente(array(
                'id'        => $app->request->post('cliente'),
                'usuario'   => $u->getUsuario()
            ));
            
            $P = new Pedidos();
            
            $Pedido = new DocumentoCliente();
            $Pedido->setCliente($cliente);
            $Pedido->setEmpresa($u->getUsuario()->getEmpresa());
            $Pedido->setTitulo($app->request->post('titulo'));


            $P->salvar($Pedido);

            $app->redirectTo('ver_pedido', array(
                'id' => $Pedido->getId()
            ));
        })
        ->name('salvar_pedido');

        
$app->get('/admin/pedidos/:id', function($id) use($app) {

            $u = WebUser::getInstance();


            $P = new Pedidos();
            $pedido = $P->getPedido(array(
                'usuario'   => $u->getUsuario(),
                'id'        => $id
            ));

            $app->render('pedidos/ver.html.twig', array(
                'menuPrincipal' => 'cadastro_pedido',
                'pedido' => $pedido,                
                'user' => $u
            ));
        })
        ->name('ver_pedido')
        ->conditions(array('id' => '[0-9]{1,}'));
        

$app->get('/admin/pedidos/:id/editar', function($id) use($app) {

            $u = WebUser::getInstance();

            $P = new Pedidos();
            $pedido = $P->getPedido(array(
                'usuario' => $u->getUsuario(),
                'id' => $id
            ));
            
            $C = new Clientes();
            $clientes = $C->getListaClientes(array(
                'usuario' => $u->getUsuario(),
                'pagina' => 1,
                'qtdPorPagina' => 400
            ));

            $app->render('pedidos/editar.html.twig', array(
                'menuPrincipal' => 'cadastro_pedido',
                'pedido' => $pedido,
                'clientes' => $clientes['registros'],
                'user' => $u
            ));
        })
        ->name('editar_pedido');



$app->post('/admin/pedidos/atualizar', function() use($app) {

            $u = WebUser::getInstance();

            // Consulta a cliente
            $A = new Pedidos();
            $Pedido = $A->getPedido(array(
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('id')
            ));

            $C = new Clientes();
            $Cliente = $C->getCliente(array(
                'usuario' => $u->getUsuario(),
                'id' => $app->request->post('cliente')
            ));
                        
            if ($Pedido instanceof DocumentoCliente) {
                $Pedido->setTitulo($app->request->post('titulo'));
                $Pedido->setCliente($Cliente);
                $A->salvar($Pedido);

                $app->flash('sucesso', 'Pedido atualizado com sucesso!');
                $app->redirectTo('ver_pedido', array(
                    'id' => $Pedido->getId()
                ));
            } else {
                $app->flash('erro', 'Pedido não encontrado');
                $app->redirectTo('lista_pedidos');
            }
        })
        ->name('atualizar_pedido');
        
$app->post('/admin/pedidos/excluir', function() use($app) {

            $u = WebUser::getInstance();

            // Classe que persiste o usuario
            $P = new Pedidos();

            // Cliente
            $Pedido = $P->getPedido(array(
                'usuario'   => $u->getUsuario(),
                'id'        => $app->request->post('id')
            ));

            if ($Pedido instanceof DocumentoCliente) {
                $P->excluir($Pedido);

                $app->flash('successo', 'Pedido excluído com sucesso!');
                $app->redirectTo('lista_pedidos');
            } else {
                $app->flash('erro', 'Pedido não encontrado!');
                $app->redirectTo('ver_pedido', array(
                    'id' => $Pedido->getId()
                ));
            }
        })
        ->name('excluir_pedido');        
        
/**
 * Listagem de pedidos
 */
$app->get('/admin/pedidos(/:pagina(/:qtdPorPagina(/:nome)))', function($pagina = 1, $qtdPorPagina = 20, $nome = '') use($app) {
            $u = WebUser::getInstance();

            $A = new Pedidos();
            $pedidos = $A->getListaPedidos(array(
                'usuario' => $u->getUsuario(),
                'text' => (!empty($nome) ? "%$nome%" : ""),
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            ));


            $parametros = array(
                'pagina' => $pagina,
                'qtdPorPagina' => $qtdPorPagina
            );

            if (!empty($nome)) {
                $parametros['nome'] = $nome;
            }

            $Paginacao = new Paginacao(array_merge(
                $pedidos['paginacao'], array(
                    'parametros'    => $parametros,
                    'rota'          => 'lista_pedidos'
                )
            ));

            $app->render('pedidos/consultar.html.twig', array(
                'menuPrincipal' => 'cadastro_pedidos',
                'user'          => $u,
                'clientes'      => $pedidos['registros'],
                'paginacao'     => $Paginacao,
                'filtro'        => array(
                    'nome' => $nome
                )
            ));
        })
        ->name('lista_pedidos');


$app->get('/admin/dashboard', function() use($app) {
            $u = WebUser::getInstance();

            if($u->getUsuario()->getEmpresa()->isAdmin() == false){            
                $app->render('admin/dashboard.html.twig', array(
                    'menuPrincipal' => 'dashboard',
                    'user' => $u
                ));
            }
            else {
                $app->render('admin/dashboard_effort.html.twig', array(
                    'menuPrincipal' => 'dashboard',
                    'user' => $u
                ));
            }
        })
        ->name('dashboard_admin');
