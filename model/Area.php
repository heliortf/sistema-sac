<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
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
    
    function __construct() {
        $this->usuarios = new ArrayCollection();
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
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="area")
     */
    private $usuarios;
    
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


}