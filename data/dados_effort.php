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

$C2 = new Cargo();
$C2->setNome(Cargo::ADMINISTRADOR);
$C2->setEmpresa($E);

$em->persist($C2);
$em->flush();

// Cadastra a área
$A = new Area();
$A->setEmpresa($E);
$A->setNome("Suporte");

$A2 = new Area();
$A2->setEmpresa($E);
$A2->setNome("Diretoria");

$em->persist($A);
$em->persist($A2);
$em->flush();


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

$qtdAcessosDistribuidos = 2000;

for($i=0;$i<$qtdAcessosDistribuidos;$i++){
    $D = new DateTime("2015-01-01");
    $D->add(new DateInterval("P".rand(5, 190)."D"));
    
    $A = new AcessoEmpresa($E);
    $A->setDataAcesso($D);
    
    $em->persist($A);    
}
$em->flush();