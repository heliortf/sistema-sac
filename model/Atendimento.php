<?php

use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * Description of Atendimento
 *
 * @Entity
 * @Table(name="tb_atendimento")
 */
class Atendimento {
    
    
    /**
     * Empresa a que o atendimento pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="atendimentos")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;
    
    /**
     * Cliente a que se refere o atendimento
     * 
     * @var Cliente
     * @ManyToOne(targetEntity="Cliente", inversedBy="atendimentos")
     * @JoinColumn(name="tb_cliente_cliente_id", referencedColumnName="cliente_id")
     */
    private $cliente;
    
    /**
     * Area onde o atendimento está
     * 
     * @var Area
     * @ManyToOne(targetEntity="Area", inversedBy="atendimentos")
     * @JoinColumn(name="tb_area_area_id", referencedColumnName="area_id")
     */
    private $area;
    
    /**
     * Usuário que está resolvendo o atendimento
     * 
     * @var Usuario
     * @ManyToOne(targetEntity="Usuario", inversedBy="meusAtendimentos")
     * @JoinColumn(name="tb_usuario_usuario_id", referencedColumnName="usuario_id", nullable=true)
     */
    private $atendente;
    
    /**
     *
     * @var StatusAtendimento
     * @ManyToOne(targetEntity="Atendimento", inversedBy="atendimentos")
     * @JoinColumn(name="tb_status_tipo_status_tipo_id", referencedColumnName="status_tipo_id")
     */
    private $status;
    
    /**
     * Construtor
     */
    function __construct() {
        
    }

    
    /**
     * ID do atendimento
     * 
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="atendimento_id")
     */
    private $id;
    
    /**
     * Titulo do atendimento
     * 
     * @var string
     * @Column(type="string", name="titulo", length=255)
     */
    private $titulo;
    
    /**
     *
     * @var string
     * @Column(type="text", name="descricao")
     */
    private $descricao;
    
    /**
     * Data de criação do atendimento
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
     * @Column(type="datetime", name="data_conclusao", nullable=true)
     */
    private $dataConclusao;    
    
    /**
     *
     * @var string
     * @Column(type="string", length=100)
     */
    private $criadoPor;
    
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
    function getAtendente() {
        return $this->atendente;
    }

    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function getDataAlteracao() {
        return $this->dataAlteracao;
    }

    function getDataConclusao() {
        return $this->dataConclusao;
    }

    function getCriadoPor() {
        return $this->criadoPor;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setCliente(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    function setAtendente(Usuario $atendente) {
        $this->atendente = $atendente;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataAlteracao($dataAlteracao) {
        $this->dataAlteracao = $dataAlteracao;
    }

    function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
    }

    function setCriadoPor($criadoPor) {
        $this->criadoPor = $criadoPor;
    }

    function getArea() {
        return $this->area;
    }

    function setArea(Area $area) {
        $this->area = $area;
    }
    
    function getStatus() {
        return $this->status;
    }

    function setStatus(StatusAtendimento $status) {
        $this->status = $status;
    }
}
