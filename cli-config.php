<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

require('vendor/autoload.php');
require('config/autoload.php');

$entityManager = Conexao::getEntityManager();
return ConsoleRunner::createHelperSet($entityManager);