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
     * @Column(type="string", name="permalink", length=30);
     */
    private $permalink;
    
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
     * @Column(type="string", name="logo", nullable=true)
     */
    protected $logo;
    
    
    function getUsuarios() {
        return $this->usuarios;
    }

    function getAreas() {
        return $this->areas;
    }

    function getPerfis() {
        return $this->perfis;
    }

    function getCargos() {
        return $this->cargos;
    }

    function getId() {
        return $this->id;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function getRazaoSocial() {
        return $this->razaoSocial;
    }

    function getNomeFantasia() {
        return $this->nomeFantasia;
    }

    function getEndereco() {
        return $this->endereco;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function getEstado() {
        return $this->estado;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getDddTelefone() {
        return $this->dddTelefone;
    }

    function getEmail() {
        return $this->email;
    }

    function getLogo() {
        return $this->logo;
    }

    function setUsuarios(ArrayCollection $usuarios) {
        $this->usuarios = $usuarios;
    }

    function setAreas(ArrayCollection $areas) {
        $this->areas = $areas;
    }

    function setPerfis(ArrayCollection $perfis) {
        $this->perfis = $perfis;
    }

    function setCargos(ArrayCollection $cargos) {
        $this->cargos = $cargos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function setRazaoSocial($razaoSocial) {
        $this->razaoSocial = $razaoSocial;
    }

    function setNomeFantasia($nomeFantasia) {
        $this->nomeFantasia = $nomeFantasia;
    }

    function setEndereco($endereco) {
        $this->endereco = $endereco;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setDddTelefone($dddTelefone) {
        $this->dddTelefone = $dddTelefone;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setLogo($logo) {
        $this->logo = $logo;
    }

    function getPermalink() {
        return $this->permalink;
    }

    function setPermalink($permalink) {
        $this->permalink = $permalink;
    }


}
