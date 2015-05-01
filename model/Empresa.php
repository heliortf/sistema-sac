<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;


/**
 * Description of Empresa
 * 
 * @Entity
 * @Table(name="tb_empresa")
 */
class Empresa {
    /**
     * Usuários da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="empresa")
     */
    private $usuarios;
    
    /**
     * Areas cadastradas para a empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Area", mappedBy="empresa")
     */
    private $areas;
	
    /**
     * Perfis cadastrados para a empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Perfil", mappedBy="empresa")
     */
    private $perfis;
    
    /**
     * Lista de cargos da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Cargo", mappedBy="empresa")
     */
    private $cargos;
    
    /**
     * Construtor
     */
    public function __construct(){
        $this->usuarios = new ArrayCollection();
        $this->areas    = new ArrayCollection();
        $this->perfis   = new ArrayCollection();
        $this->cargos   = new ArrayCollection();
    }
    
    /**
     *
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="empresa_id")
     */
    private $id;
    
    /**
     *
     * @var string
     * @Column(type="string", name="cnpj", length=14)
     */
    private $cnpj;
    
    /**
     *
     * @var string
     * @Column(type="string", name="razao_social")
     */
    private $razaoSocial;
    
    /**
     *
     * @var string
     * @Column(type="string", name="nome_fantasia")
     */
    private $nomeFantasia;
    
    /**
     *
     * @var string
     * @Column(type="string", name="endereco", length=255)
     */
    private $endereco;
    
    /**
     *
     * @var string
     * @Column(type="string", name="bairro", length=120)
     */
    private $bairro;
    
    /**
     *
     * @var string
     * @Column(type="string", name="cidade", length=120)
     */
    private $cidade;
    
    /**
     *
     * @var string
     * @Column(type="string", name="estado", length=25)
     */
    private $estado;
    
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
     * @Column(type="string", length=255, name="email")
     */
    protected $email;
    
    /**
     *
     * @var string
     * @Column(type="string", name="logo")
     */
    protected $logo;
}
