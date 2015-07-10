<?php

use Doctrine\Common\Collections\ArrayCollection;
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
 * @Table(name="tb_documentos_cliente")
 */
class DocumentoCliente {    
    
    /**
     * Empresa a que o atendimento pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="documentos")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;   
        
    /**
     * Usuário que fez o comentario
     * 
     * @var Cliente
     * @ManyToOne(targetEntity="Cliente", inversedBy="documentos")
     * @JoinColumn(name="tb_cliente_cliente_id", referencedColumnName="cliente_id", nullable=true)
     */
    private $cliente;
	
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="documento")
     */
    private $atendimentos;
    
    /**
     * Construtor
     */
    function __construct() {
        $this->atendimentos = new ArrayCollection();
    }
    
    /**
     * ID do documento
     * 
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="documento_id")
     */
    private $id;
        
    /**
     *
     * @var string
     * @Column(type="string", name="titulo")
     */
    private $titulo;
    
    
    function getEmpresa() {
        return $this->empresa;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setCliente(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    
    function getAtendimentos() {
        return $this->atendimentos;
    }

    function setAtendimentos(ArrayCollection $atendimentos) {
        $this->atendimentos = $atendimentos;
    }
}
