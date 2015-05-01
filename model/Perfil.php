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
 * @Table(name="tb_perfil")
 */
class Perfil {
    
    /**
     * Empresa que o perfil pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="perfis")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    protected $empresa;
    
    /**
     * Lista de acoes que este perfil pode ter
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="AcaoPerfil", mappedBy="perfil")
     */
    protected $acoes;    
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="cargo")
     */
    protected $usuarios;
    
    /**
     * Construtor
     */
    function __construct() {        
        $this->acoes = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
    }

    
    /**
     *
     * @var int
     * @Id
     * @Column(type="integer", name="perfil_id")
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
}

