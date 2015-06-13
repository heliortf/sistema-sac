<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cliente
 *
 * @Entity
 * @Table(name="tb_cliente")
 */
class Cliente {
    
    /**
     *
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="clientes")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;
    
    /**
     * Lista de atendimentos do cliente
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="cliente")
     */
    protected $atendimentos;
    
    function __construct() {
        $this->atendimentos = new ArrayCollection();
    }

    
    /**
     *
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="cliente_id")
     */
    private $id;
    
    /**
     *
     * @var string
     * @Column(type="string", length=255)
     */
    private $nome;
    
    /**
     *
     * @var string     
	 * @Column(type="string", length=255, nullable=true)
     */
    private $endereco;
    
	/**
     *
     * @var int
	 * @Column(type="int", length=8, nullable=true)
     */
    private $numero;
    
	/**
     *
     * @var string     
	 * @Column(type="string", length=120, nullable=true)
     */
    private $bairro;
    
	/**
     *
     * @var string     
	 * @Column(type="string", length=100, nullable=true)
     */
    private $cidade;
    
	/**
     *
     * @var string     
	 * @Column(type="string", length=30, nullable=true)
     */
    private $estado;
    
	/**
     *
     * @var string     
	 * @Column(type="int", length=8, nullable=true)
     */
    private $cep;
    
    /**
     * Login do cliente
     * 
     * @var string
     * @Column(type="string", length=50)
     */
    private $login;
    
    /**
     *
     * @var string
     * @Column(type="string", length=20)
     */
    private $senha;
    
    /**
     *
     * @var integer
     * @Column(type="string", length=14, nullable=true)
     */
    private $cnpj;
    
    /**
     *
     * @var integer
     * @Column(type="string", length=11, nullable=true)
     */
    private $cpf;
    
    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    private $email;
    
    /**
     * Telefone do cliente
     * 
     * @var integer
     * @Column(type="integer", length=9, nullable=true)
     */
    private $telefone;
    
    /**
     * DDD do telefone
     * 
     * @var integer
     * @Column(type="integer", name="telefone_ddd", length=3, nullable=true)
     */
    private $dddTelefone;
    
    /**
     *
     * @var integer
     * @Column(type="integer", name="celular", length=9, nullable=true)
     */
    private $celular;
    
    /**
     *
     * @var integer
     * @Column(type="integer", name="celular_ddd", length=3, nullable=true)
     */
    private $dddCelular;
    
    /**
     *
     * @var string
     * @Column(type="datetime", name="data_criacao")
     */
    private $dataCriacao;
    
    /**
     *
     * @var string
     * @Column(type="datetime", name="data_alteracao", nullable=true)
     */
    private $dataAlteracao;
    
    /**
     *
     * @var string
     * @Column(type="datetime", name="data_acesso", nullable=true)
     */
    private $dataAcesso;
    
    /**
     * 
     * @return Empresa
     */
    function getEmpresa() {
        return $this->empresa;
    }

    /**
     * 
     * @return ArrayCollection
     */
    function getAtendimentos() {
        return $this->atendimentos;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getEmail() {
        return $this->email;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getDddTelefone() {
        return $this->dddTelefone;
    }

    function getCelular() {
        return $this->celular;
    }

    function getDddCelular() {
        return $this->dddCelular;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function getDataAlteracao() {
        return $this->dataAlteracao;
    }

    function getDataAcesso() {
        return $this->dataAcesso;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setAtendimentos(ArrayCollection $atendimentos) {
        $this->atendimentos = $atendimentos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setTelefone($telefone) {
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        $this->telefone = (empty($telefone) ? null : $telefone);
    }

    function setDddTelefone($dddTelefone) {
        $dddTelefone = preg_replace("/[^0-9]/", "", $dddTelefone);
        $this->dddTelefone = (empty($dddTelefone) ? null : $dddTelefone);
    }

    function setCelular($celular) {
        $celular = preg_replace("/[^0-9]/", "", $celular);
        $this->celular = (empty($celular) ? null : $celular);
    }

    function setDddCelular($dddCelular) {
        $dddCelular = preg_replace("/[^0-9]/", "", $dddCelular);
        $this->dddCelular = (empty($dddCelular) ? null : $dddCelular);
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataAlteracao($dataAlteracao) {
        $this->dataAlteracao = $dataAlteracao;
    }

    function setDataAcesso($dataAcesso) {
        $this->dataAcesso = $dataAcesso;
    }

    function getLogin() {
        return $this->login;
    }

    function setLogin($login) {
        $this->login = $login;
    }
	
	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	
	public function setNumero($numero){
		$this->numero = $numero;
	}
	
	public function setBairro($bairro){
		$this->bairro = $bairro;
	}
	
	public function setCidade($cidade){
		$this->cidade = $cidade;
	}
	
	public function setEstado($estado){
		$this->estado = $estado;
	}
	
	public function setCep($cep){
		$this->cep = $cep;
	}
	
	public function getCep(){
		return $this->cep;
	}
	
	public function getEstado(){
		return $this->estado;
	}
	
	public function getCidade(){
		return $this->cidade;
	}
	
	public function getBairro(){
		return $this->bairro;
	}
	
	public function getEndereco(){
		return $this->endereco;
	}
	
	public function getNumero(){
		return $this->numero;
	}
}
