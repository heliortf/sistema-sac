<?php

global $app;

// Consulta de clientes e retorno em json
$app->get('/email-template/:permalink/logotipo/', function($permalink) use($app) {
    
    $E = new Empresas();
    $lista = $E->getLista(array( 'permalink' => $permalink, 'pagina' => 1, 'qtdPorPagina' => 2 ));
    
    if(count($lista['registros']) == 1){
        $Empresa = $lista['registros'][0];
        $arr = explode(".", $Empresa->getLogo());
        $extensao = $arr[count($arr) - 1];
        $app->response->headers->set('Content-Type', "image/{$extensao}");
        $app->response->setBody(file_get_contents(Config::$uploadPath.$Empresa->getLogo()));
    }
    else {
        echo "Achou mais..";
    }
//    echo 
})
->name('email_template_logotipo');