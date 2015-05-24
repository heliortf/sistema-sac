<?php

use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * Description of Comentario Atendimento
 *
 * @Entity
 * @Table(name="tb_comentario_atendimento")
 */
class ComentarioAtendimento {    
    
    /**
     * Empresa a que o atendimento pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="comentarios")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;   
        
    /**
     * Usuário que fez o comentario
     * 
     * @var Usuario
     * @ManyToOne(targetEntity="Usuario", inversedBy="comentarios")
     * @JoinColumn(name="tb_usuario_usuario_id", referencedColumnName="usuario_id", nullable=true)
     */
    private $usuario;
	
	/**
	 * Atendimento onde foi feito o comentario
	 *
	 * @var Atendimento
	 * @ManyToOne(targetEntity="Atendimento", inversedBy="comentarios")
	 * @JoinColumn(name="tb_atendimento_atendimento_id", referencedColumnName="atendimento_id")
	 */
	private $atendimento;
    
    /**
     * Construtor
     */
    function __construct() {
        
    }
    
    /**
     * ID do commentario
     * 
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="atendimento_id")
     */
    private $id;
        
    /**
     *
     * @var string
     * @Column(type="text", name="descricao")
     */
    private $descricao;
    
	/**
     * Flag que define se o comentario é publico ou não
	 *
     * @var int
     * @Column(name="publico", length=1, type="integer")
     */
    private $publico;
	
    /**
     * Data de criação do atendimento
     * 
     * @var string
     * @Column(type="datetime", name="data_criacao")
     */
    private $dataCriacao;
    	
    /**
     * 
     * @return Empresa
     */
    function getEmpresa() {
        return $this->empresa;
    }

    /**
     * 
     * @return Cliente
     */
    function getCliente() {
        return $this->cliente;
    }

    /**
     * 
     * @return Usuario
     */
    function getUsuario() {
        return $this->usuario;
    }
	
	/**
	 * @return Atendimento
	 */
	function getAtendimento() {
		return $this->atendimento;
	}

    function getId() {
        return $this->id;
    }
	
	function isPublico() {
		return $this->publico == 1 ? true : false;
	}

    function getDescricao() {
        return $this->descricao;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setUsuario(Usuario $usuario) {
        $this->usuario = $usuario;
    }

    function setId($id) {
        $this->id = $id;
    }
	
    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
	
	function setPublico($publico){
		$this->publico = $publico;
	}

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }
}
