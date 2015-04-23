<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * @Entity
 * @Table(name="tb_usuario")
 */
class Usuario {
    
    function __construct() {
        $this->areas = new ArrayCollection();
    }

    
    /**
     *
     * @var int
     * @Id
     * @Column(type="integer", name="usuario_id")
     * @GeneratedValue
     */
    protected $id;
    
    /**
     *
     * @var Cargo
     * @ManyToOne(targetEntity="Cargo", inversedBy="usuarios")
     * @JoinColumn(name="tb_cargo_cargo_id", referencedColumnName="cargo_id")
     */
    protected $cargo;
    
    /**
     * Area que o usuário pertence
     *      
     * @var Area
     * @ManyToOne(targetEntity="Area", inversedBy="usuarios")
     * @JoinColumn(name="tb_area_area_id", referencedColumnName="area_id")
     */
    protected $area;
    
    /**
     *
     * @var string
     * @Column(type="string")
     */
    protected $nome;
    
    /**
     *
     * @var string
     * @Column(type="string")
     */
    protected $login;
    
    /**
     *
     * @var string
     * @Column(type="string")
     */
    protected $email;
    
    /**
     *
     * @var string
     * @Column(type="string", length=20)
     */
    protected $senha;
    
    /**
     *
     * @var string
     * @Column(type="string", length=11)
     */
    protected $cpf;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=8)
     */
    protected $telefone;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=3, name="telefone_ddd")
     */
    protected $dddTelefone;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=9)
     */
    protected $celular;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=3, name="celular_ddd")
     */
    protected $dddCelular;
}