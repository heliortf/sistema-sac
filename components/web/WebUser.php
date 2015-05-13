<?php

class WebUser {
	/**
	 * WebUser
	 */
	private static $instance = null;
	
	/**
	 * @param Usuario $usuario
	 */
	private $usuario;
	
	/**
	 * Indica se está logado ou não
	 *
	 * @param boolean $logado
	 */
	private $logado;

	/**
	 * Construtor
	 */
	private function __construct(){
		if(isset($_SESSION['usuario']) && is_numeric($_SESSION['usuario']) && $_SESSION['usuario'] > 0){
			$this->logado = true;
			$em = Conexao::getEntityManager();
			$this->usuario = $em->find('Usuario', $_SESSION['usuario']);
		}
		else {
			$this->logado = false;
		}
	}
	
	public static function getInstance(){
		if(self::$instance == null){
			self::$instance = new WebUser();
		}
		return self::$instance;
	}
	
	/**
	 * Indica se um usuário está logado ou não no sistema
	 *
	 * @return boolean
	 */
	public function isLogado(){
		return $this->logado;
	}
}