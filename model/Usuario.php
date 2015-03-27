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
     * @JoinColumn(name="cargo_id", referencedColumnName="cargo_id")
     */
    protected $cargo;
    
    /**
     * Lista de áreas que o usuário pertence
     * 
     * @var ArrayCollection
     * @ManyToMany(targetEntity="Area", inversedBy="usuarios")
     * @JoinTable(name="tb_usuario_area",
     *          joinColumns={@JoinColumn(name="tb_usuario_usuario_id", referencedColumnName="usuario_id")},
     *          inversedJoinColumns={@JoinColumn(name="area_id", referebcedColumnName="area_id")}
     *      )
     */
    protected $areas;
    
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