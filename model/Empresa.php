<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
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
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Usuario", mappedBy="empresa")
     */
    private $usuarios;
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Area", mappedBy="empresa")
     */
    private $areas;
	
	/**
	 *
	 * @var ArrayCollection
	 * @OneToMany(targetEntity="Perfil", mappedBy="empresa")
	 */
	private $perfis;
    
    public function __construct(){
        $this->usuarios = new ArrayCollection();
        $this->areas    = new ArrayCollection();
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
	 * @Column(type="string", name="endereco")
	 */
	private $endereco;
	
	/**
	 *
	 * @var string
	 * @Column(type="string", name="bairro")
	 */
	private $bairro;
	
	/**
	 *
	 * @var string
	 * @Column(type="string", name="cidade")
	 */
	private $cidade;
	
	/**
	 *
	 * @var string
	 * @Column(type="string", name="estado", length=30)
 	 */
	private $estado;
	
	/**
	 *
	 * @var integer
	 * @Column(type="integer", name="telefone", length=9)
	 */
	private $telefone;
	
	/**
	 *
	 * @var integer
	 * @Column(type="integer", name="telefone_ddd", length=2)
	 */
	private $dddTelefone;
	
	/**
	 *
	 * @var string
	 * @Column(type="string", name="email")
	 */
	private $email;
	
	/**
	 *
	 * @var string
	 * @Column(type="text", name="logo")
	 */
	private $logo;
}
