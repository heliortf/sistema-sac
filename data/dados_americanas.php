<?php

global $em;

// Cadastra a empresa
$E = new Empresa();
$E->setPermalink("lojas-americanas");
$E->setNomeFantasia("Americanas.com");
$E->setRazaoSocial("Lojas Americanas");
$E->setCnpj(07699789000129);
$E->setEmail("faleconosco@americanas.com.br");
$E->setTelefone(27687236);
$E->setDddTelefone(21);
$E->setCep(26041145);
$E->setEstado("Rio de Janeiro");
$E->setCidade("Nova Iguaçu");
$E->setBairro("Centro");
$E->setEndereco("R. Getulio de Moura, 1120");
$E->setAdmin(false);
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
$A2->setNome("Entregas");

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
$U->setNome("Rosa Maria");
$U->setEmail("heliortf@gmail.com");
$U->setLogin("atendente.americanas");
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
$U2->setCpf(13334123711);
$U2->setNome("Arnaldo Barcelos");
$U2->setEmail("arnaldo.barcelos@gmail.com");
$U2->setLogin("responsavel.americanas");
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
$U3->setNome("Anastácia Oliveira Cruz");
$U3->setEmail("anastacia@gmail.com");
$U3->setLogin("admin.americanas");
$U3->setSenha('12345');
$U3->setDddCelular(21);
$U3->setCelular(992491622);
$U3->setDddTelefone(21);
$U3->setTelefone(27685432);

$em->persist($U3);
$em->flush();


$Status1 = new StatusAtendimento();
$Status1->setEmpresa($E);
$Status1->setNome(StatusAtendimento::STATUS_ABERTO);

$Status2 = new StatusAtendimento();
$Status2->setEmpresa($E);
$Status2->setNome(StatusAtendimento::STATUS_ANALISE_AREA);

$Status3 = new StatusAtendimento();
$Status3->setEmpresa($E);
$Status3->setNome(StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO);

$Status4 = new StatusAtendimento();
$Status4->setEmpresa($E);
$Status4->setNome(StatusAtendimento::STATUS_CONCLUIDO_E_AVALIADO);

$em->persist($Status1);
$em->persist($Status2);
$em->persist($Status3);
$em->persist($Status4);
$em->flush();


/**
 * Cria os clientes da americanas
 */
$C = new Cliente();
$C->setEmpresa($E);
$C->setNome("José da Silva Souza");
$C->setCpf(11156598716);
$C->setCelular(998778956);
$C->setDddCelular(21);
$C->setTelefone(26598856);
$C->setDddTelefone(21);
$C->setEmail("heliortf@gmail.com");
$C->setLogin("cliente");
$C->setSenha("12345");
$C->setDataCriacao(new DateTime());

$em->persist($C);

$C2 = new Cliente();
$C2->setEmpresa($E);
$C2->setNome("Josias Ferreira");
$C2->setCpf(12342123451);
$C2->setCelular(998778956);
$C2->setDddCelular(21);
$C2->setTelefone(26598856);
$C2->setDddTelefone(21);
$C2->setEmail("josiasf@gmail.com");
$C2->setLogin("cliente2");
$C2->setSenha("12345");
$C2->setDataCriacao(new DateTime());

$em->persist($C2);
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

echo $AT->getEmpresa()->getNomeFantasia()."<br/>";