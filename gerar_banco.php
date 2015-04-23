<?php

use Doctrine\ORM\Tools\SchemaTool;

require('vendor/autoload.php');
require('config/autoload.php');

$em = Conexao::getEntityManager();

$tool = new SchemaTool($em);
$classes = array(
  $em->getClassMetadata('Empresa'),
  $em->getClassMetadata('Area')
);
$tool->createSchema($classes);

