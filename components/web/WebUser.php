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
            
            switch($_SESSION['tipo_usuario']){
                case 'usuario':
                    $this->usuario = $em->find('Usuario', $_SESSION['usuario']);
                    break;
                case 'cliente':
                    $this->usuario = $em->find('Cliente', $_SESSION['usuario']);
                    break;
            }            
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
     * Verifica se o usuario logado é um usuario do sistema
     * 
     * @return boolean
     */
    public function isUsuario() {
        return $this->getTipoUsuario() == 'usuario' ? true : false;
    }
    
    /**
     * Verifica se o usuario logado é um cliente
     * 
     * @return boolean
     */
    public function isCliente() {
        return $this->getTipoUsuario() == 'cliente' ? true : false;
    }

    /**
     * Retorna o tipo do usuario
     * 
     * @return string
     */
    public function getTipoUsuario(){
        return ($this->usuario instanceof Usuario ? 'usuario' : 'cliente');
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
