<?php

global $em;

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
$E->setAdmin(true);
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

$U = new Usuario();
$U->setEmpresa($E);
$U->setCargo($C);
$U->setArea($A);
$U->setCpf(13447868716);
$U->setNome("Helio Ricardo");
$U->setEmail("heliortf@gmail.com");
$U->setLogin("atendente");
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
$U2->setCpf(13643828711);
$U2->setNome("João Lopes");
$U2->setEmail("joao.lopes@gmail.com");
$U2->setLogin("responsavel");
$U2->setSenha('12345');
$U2->setDddCelular(21);
$U2->setCelular(992491622);
$U2->setDddTelefone(21);
$U2->setTelefone(27685432);

$em->persist($U2);


$U3 = new Usuario();
$U3->setEmpresa($E);
$U3->setCargo($C2);
$U3->setArea($A2);
$U3->setCpf(13643828711);
$U3->setNome("Gideão");
$U3->setEmail("gideao@gmail.com");
$U3->setLogin("admin");
$U3->setSenha('12345');
$U3->setDddCelular(21);
$U3->setCelular(992491622);
$U3->setDddTelefone(21);
$U3->setTelefone(27685432);

$em->persist($U3);
$em->flush();

