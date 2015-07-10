<?php
ini_set('max_execution_time', 90);

require('vendor/autoload.php');
require('config/autoload.php');

date_default_timezone_set('America/Sao_Paulo');

$Empresas = new Empresas();
$lista = $Empresas->getLista(array(
    'permalink' => 'lojas-americanas',
    'pagina' => 1,
    'qtdPorPagina' => 1
));

$Empresa = $lista['registros'][0];


$Atendimentos = new Atendimentos();
$A = $Atendimentos->getAtendimento(array('id' => 5, 'usuario' => $Empresa->getResponsavel()));

$M = new SacMailer($Empresa);
$enviou = $M->enviarEmailInicioAtendimento(array(
    'cliente' => $A->getCliente(),
    'atendimento' => $A,
    'url_logotipo' => 'http://localhost/sac/lojas-americanas/logotipo'
));

var_dump($enviou);

if($enviou == false){
    echo "<pre>"; 
    var_dump($M->getMailer());
}
else {
    echo "Enviou!";
}