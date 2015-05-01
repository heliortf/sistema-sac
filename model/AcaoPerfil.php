<?php

use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;



/**
 * Description of AcaoPerfil
 *
 * @Entity
 * @Table(name="tb_acaoperfil")
 */
class AcaoPerfil {
    
    /**
     *
     * @var Perfil
     * @ManyToOne(targetEntity="Perfil", inversedBy="acoes")
     * @JoinColumn(name="tb_perfil_perfil_id", referencedColumnName="perfil_id")
     */
    private $perfil;
    
    /**
     * Construtor
     */
    public function __construct(){
        
    }
    
    /**
     * Chave Primaria
     * 
     * @var int
     * @Id
     * @Column(type="integer", name="acaoperfil_id")
     * @GeneratedValue
     */
    private $id;
    
    /**
     * Nome da ação
     * 
     * @var string
     * @Column(type="string", name="nome", length=80)
     */
    private $nome;
    
}
