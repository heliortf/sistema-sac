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
 * @Table(name="tb_perfil")
 */
class Perfil {
    
    /**
     * Cargo a quem pertence o perfil
     * 
     * @var Cargo
	 * @OneToMany(targetEntity="Cargo", mappedBy="perfil")
     */
    private $cargos;
	
	/**
	 * Empresa a quem pertence este perfil
	 *
	 * @var Empresa
	 * @ManyToOne(targetEntity="empresa", inversedBy="perfis")
	 * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
	 */
	private $empresa;
	
    
    function __construct() {
        
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
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="cargo")
     */
    private $usuarios;
}

