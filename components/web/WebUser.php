<?php

class WebUser {

    /**
     * @param WebUser $instance
     */
    private static $instance = null;

    /**
     * Usuário consultado
     * 
     * @param Usuario $usuario
     */
    private $usuario;

    /**
     * Indica se esta logado ou nao
     *
     * @param boolean $logado
     */
    private $logado;

    /**
     * Construtor
     */
    private function __construct() {        
        if (isset($_SESSION['usuario']) && is_numeric($_SESSION['usuario']) && $_SESSION['usuario'] > 0) {            
            $this->logado = true;
            $em = Conexao::getEntityManager();
            $this->usuario = $em->find('Usuario', $_SESSION['usuario']);
        } else {
            $this->logado = false;
        }
    }

    /**
     * 
     * @return WebUser
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new WebUser();
        }
        return self::$instance;
    }

    /**
     * Indica se um usu�rio esta logado ou nao no sistema
     *
     * @return boolean
     */
    public function isLogado() {
        return $this->logado;
    }

    /**
     * Retorna a instancia do usuario logado
     * 
     * @return Usuario
     */
    function getUsuario() {
        return $this->usuario;
    }    
}
