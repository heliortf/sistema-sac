<?php

use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * @Entity
 * @Table(name="tb_usuario")
 */
class Usuario {
    
    /**
     * Cargo do usuario
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
     * Empresa que o usuario pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="usuarios")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    protected $empresa;
    
    function __construct() {
        
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