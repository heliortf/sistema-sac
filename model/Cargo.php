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
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="cargo")
     */
    private $usuarios;
}

