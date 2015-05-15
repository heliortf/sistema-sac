<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * 
 * @Entity
 * @Table(name="tb_area")
 */
class Area {
    
    /**
     * Empresa que a area pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="areas")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    protected $empresa;
    
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="area")
     */
    private $usuarios;
    
    /**
     * Lista de atendimentos da area
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="area")
     */
    protected $atendimentos;
    
    function __construct() {
        $this->usuarios = new ArrayCollection();
        $this->atendimentos = new ArrayCollection();
    }

    
    /**
     *
     * @var int
     * @Id
     * @Column(type="integer", name="area_id")
     * @GeneratedValue
     */
    private $id;    
    
    /**
     * Nome da area
     * 
     * @var string
     * @Column(type="string", name="area_nome")
     */
    private $nome;    
    
    function getEmpresa() {
        return $this->empresa;
    }

    function getId() {
        return $this->id;
    }

    function getUsuarios() {
        return $this->usuarios;
    }

    function getNome() {
        return $this->nome;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuarios(ArrayCollection $usuarios) {
        $this->usuarios = $usuarios;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getAtendimentos() {
        return $this->atendimentos;
    }

    function setAtendimentos(ArrayCollection $atendimentos) {
        $this->atendimentos = $atendimentos;
    }


}