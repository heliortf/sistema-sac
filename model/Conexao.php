<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Portability\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class Conexao {
    /**
     *
     * @var Connection
     */
    protected static $conn = null;
    
    /**
     *
     * @var EntityManager
     */
    protected static $em = null;
    
    /**
     * Retorna a conexão do banco de dados
     * 
     * @return Connection
     */
    public static function get(){
        if(is_null(self::$conn)){
            self::$conn = DriverManager::getConnection(Config::$db);
        }
        return self::$conn;
    }
    
    /**
     * 
     * @return EntityManager
     */
    public static function getEntityManager(){
        if(is_null(self::$em)){
            $isDevMode = true;
            $modelPath = dirname(__FILE__);
            $config = Setup::createAnnotationMetadataConfiguration(array($modelPath), $isDevMode);
            
            // Instancia o entity manager
            self::$em = EntityManager::create(array(
                'driver'    => 'pdo_mysql',
                'user'      => Config::$db['dbuser'],
                'password'  => Config::$db['dbpassword'],
                'dbname'    => Config::$db['dbname'],
                'host'      => Config::$db['host']
            ), $config);
        }
        return self::$em;
    }
}

