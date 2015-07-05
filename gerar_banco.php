<?php

use Doctrine\ORM\Tools\SchemaTool;
ini_set('max_execution_time', 90);

require('vendor/autoload.php');
require('config/autoload.php');

date_default_timezone_set('America/Sao_Paulo');

global $em;
$em = Conexao::getEntityManager();

$tool = new SchemaTool($em);
$classes = array(
    $em->getClassMetadata('Empresa'),  
    $em->getClassMetadata('Area'),
    $em->getClassMetadata('Cargo'),
    $em->getClassMetadata('Usuario'),
    $em->getClassMetadata('Cliente'),
    $em->getClassMetadata('StatusAtendimento'),
    $em->getClassMetadata('TipoAtendimento'),
    $em->getClassMetadata('Atendimento'),
    $em->getClassMetadata('ComentarioAtendimento'),	
    $em->getClassMetadata('DocumentoCliente')
);
$tool->dropSchema($classes);
$tool->createSchema($classes);

require_once('data/dados_effort.php');
require_once('data/dados_americanas.php');