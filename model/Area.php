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
     * @ManyToMany(targetEntity="Usuario", mappedBy="areas")
     */
    private $usuarios;
    
    /**
     * Nome da area
     * 
     * @var string
     * @Column(type="string", name="nome")
     */
    private $nome;
    
    
}