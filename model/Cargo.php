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
 * @Table(name="tb_cargo")
 */
class Cargo {
    
    const ATENDENTE = 'atendente';
	
    const RESPONSAVEL_AREA = 'responsavel_area';
    
    const ADMINISTRADOR = 'administrador';
    
    
    /**
     * Empresa que o perfil pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="cargos")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    protected $empresa;
        
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="cargo")
     */
    protected $usuarios;
    
    function __construct() {
        $this->usuarios = new ArrayCollection();
    }

    
    /**
     *
     * @var int
     * @Id
     * @Column(type="integer", name="cargo_id")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * Nome do cargo
     * 
     * @var string
     * @Column(type="string", name="nome")
     */
    private $nome;
 
    
    function getEmpresa() {
        return $this->empresa;
    }

    function getUsuarios() {
        return $this->usuarios;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }
    
    function getLabel() {
        switch($this->getNome()){
            case Cargo::ATENDENTE:
                return 'Atendente';
            case Cargo::RESPONSAVEL_AREA:
                return 'Responsável Área';
            case Cargo::ADMINISTRADOR:
                return 'Administrador';
        }
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setUsuarios(ArrayCollection $usuarios) {
        $this->usuarios = $usuarios;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }
}

