<?php

class Config {
    /**
     * Configurações do banco de dados
     * 
     * @var array
     */
    public static $db = array(
        'dbname'        => 'sac',
        'dbuser'        => 'root',
        'dbpassword'    => '',
        'host'          => 'localhost',
        'port'          => '3306'
//        'dbname'        => 'helioequipamen6',
//        'dbuser'        => 'helioequipamen6',
//        'dbpassword'    => 'h3xw9c',
//        'host'          => 'mysql01.helioequipamentos.hospedagemdesites.ws',
//        'port'          => '3306'
    );
    
    public static $uploadPath = '';
}

/**
 * Caminho de uploads
 */
Config::$uploadPath = dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR;

