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

$em->persist($C);
$em->flush();

// Cadastra a área
$A = new Area();
$A->setEmpresa($E);
$A->setNome("Suporte");

$em->persist($A);
$em->flush();

// Cadastra o perfil
$P = new Perfil();
$P->setNome("Atendente");
$P->setEmpresa($E);

$em->persist($P);
$em->flush();


$U = new Usuario();
$U->setEmpresa($E);
$U->setCargo($C);
$U->setArea($A);
$U->setCpf(13447868716);
$U->setNome("Helio Ricardo");
$U->setEmail("heliortf@gmail.com");
$U->setLogin("heliortf");
$U->setSenha('h3xw9c');
$U->setDddCelular(21);
$U->setCelular(992098791);
$U->setDddTelefone(21);
$U->setTelefone(27687236);

$em->persist($U);
$em->flush();
