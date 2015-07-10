<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * 
 * @Entity
 * @Table(name="tb_acessos")
 */
class AcessoEmpresa {
    
    /**
     * Empresa que o perfil pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="acessos")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;        
    
    /**
     *
     * @var int
     * @Id
     * @Column(type="integer", name="acesso_id")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * Nome do cargo
     * 
     * @var string
     * @Column(type="datetime", name="dataAcesso")
     */
    private $dataAcesso;
    
    function __construct(Empresa $empresa) {
        $this->empresa = $empresa;
        $this->dataAcesso = new DateTime();
    }

    
    function getEmpresa() {
        return $this->empresa;
    }

    function getId() {
        return $this->id;
    }

    function getDataAcesso() {
        return $this->dataAcesso;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDataAcesso($dataAcesso) {
        $this->dataAcesso = $dataAcesso;
    }

    
    
}

