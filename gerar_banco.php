<?php

use Doctrine\ORM\Tools\SchemaTool;
ini_set('max_execution_time', 90);

require('vendor/autoload.php');
require('config/autoload.php');

$em = Conexao::getEntityManager();

$tool = new SchemaTool($em);
$classes = array(
    $em->getClassMetadata('Empresa'),  
    $em->getClassMetadata('Area'),
    $em->getClassMetadata('Cargo'),
    $em->getClassMetadata('Usuario'),
    $em->getClassMetadata('Perfil'),
    $em->getClassMetadata('AcaoPerfil'),
    $em->getClassMetadata('Cliente'),
    $em->getClassMetadata('StatusAtendimento'),
    $em->getClassMetadata('TipoAtendimento'),
    $em->getClassMetadata('Atendimento'),
);
$tool->dropSchema($classes);
$tool->createSchema($classes);


// Cadastra a empresa
$E = new Empresa();
$E->setPermalink("effort");
$E->setNomeFantasia("Effort");
$E->setRazaoSocial("Effort Ltda");
$E->setCnpj(07610883000109);
$E->setEmail("faleconosco@effort.com.br");
$E->setTelefone(27687236);
$E->setDddTelefone(21);
$E->setEstado("Rio de Janeiro");
$E->setCidade("Nova Iguaçu");
$E->setBairro("Centro");
$E->setEndereco("R. Otávio Tarquino, 56");
$em->persist($E);
$em->flush();


// Cadastra o cargo
$C = new Cargo();
$C->setNome(Cargo::ATENDENTE);
$C->setEmpresa($E);

$C2 = new Cargo();
$C2->setNome(Cargo::ADMINISTRADOR);
$C2->setEmpresa($E);

$C3 = new Cargo();
$C3->setNome(Cargo::RESPONSAVEL_AREA);
$C3->setEmpresa($E);

$em->persist($C);
$em->persist($C2);
$em->persist($C3);
$em->flush();

// Cadastra a área
$A = new Area();
$A->setEmpresa($E);
$A->setNome("Suporte");

$A2 = new Area();
$A2->setEmpresa($E);
$A2->setNome("Diretoria");

$A3 = new Area();
$A3->setEmpresa($E);
$A3->setNome("Financeiro");

$em->persist($A);
$em->persist($A2);
$em->persist($A3);
$em->flush();

// Cadastra o perfil
$P = new Perfil();
$P->setNome("Atendente");
$P->setEmpresa($E);

$P2 = new Perfil();
$P2->setNome("Administrador");
$P2->setEmpresa($E);

$P3 = new Perfil();
$P3->setNome("Responsavel por Área");
$P3->setEmpresa($E);

$em->persist($P);
$em->persist($P2);
$em->persist($P3);
$em->flush();


$U = new Usuario();
$U->setEmpresa($E);
$U->setCargo($C);
$U->setArea($A);
$U->setPerfil($P);
$U->setCpf(13447868716);
$U->setNome("Helio Ricardo");
$U->setEmail("heliortf@gmail.com");
$U->setLogin("heliortf");
$U->setSenha('12345');
$U->setDddCelular(21);
$U->setCelular(992098791);
$U->setDddTelefone(21);
$U->setTelefone(27687236);

$em->persist($U);


$U2 = new Usuario();
$U2->setEmpresa($E);
$U2->setCargo($C3);
$U2->setArea($A);
$U2->setPerfil($P3);
$U2->setCpf(13643828711);
$U2->setNome("João Lopes");
$U2->setEmail("joao.lopes@gmail.com");
$U2->setLogin("jlopes");
$U2->setSenha('12345');
$U2->setDddCelular(21);
$U2->setCelular(992491622);
$U2->setDddTelefone(21);
$U2->setTelefone(27685432);

$em->persist($U2);

$em->flush();


/**
 * Cria os clientes da effort
 */
$C = new Cliente();
$C->setEmpresa($E);
$C->setNome("José da Silva Souza");
$C->setCpf(11156598716);
$C->setCelular(998778956);
$C->setDddCelular(21);
$C->setTelefone(26598856);
$C->setDddTelefone(21);
$C->setEmail("jose.silva.souza@gmail.com");
$C->setSenha("12345");
$C->setDataCriacao(new DateTime());

$em->persist($C);
$em->flush();


/**
 * Cria os atendimentos
 */
$TipoA1 = new TipoAtendimento();
$TipoA1->setNome("Solicitação");

$TipoA2 = new TipoAtendimento();
$TipoA2->setNome("Sugestão");

$TipoA3 = new TipoAtendimento();
$TipoA3->setNome("Elogio");

$em->persist($TipoA1);
$em->persist($TipoA2);
$em->persist($TipoA3);
$em->flush();

$Status1 = new StatusAtendimento();
$Status1->setNome("Em Aberto");

$Status2 = new StatusAtendimento();
$Status2->setNome("Análise Área");

$Status3 = new StatusAtendimento();
$Status3->setNome("Concluído - Não Avaliado");

$Status4 = new StatusAtendimento();
$Status4->setNome("Concluído - Avaliado");

$em->persist($Status1);
$em->persist($Status2);
$em->persist($Status3);
$em->persist($Status4);
$em->flush();


$AT = new Atendimento();
$AT->setEmpresa($E);
$AT->setCliente($C);
$AT->setArea($A);
$AT->setAtendente($U);
$AT->setCriadoPor($U->getNome());
$AT->setStatus($Status1);
$AT->setTipo($TipoA1);
$AT->setDataCriacao(new DateTime());
$AT->setTitulo("Cliente gostaria de receber 2ª via do boleto");
$AT->setDescricao("O cliente gostaria de receber a 2ª via por e-mail");

$em->persist($AT);
$em->flush();