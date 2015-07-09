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
     * @OneToMany(targetEntity="Usuario", mappedBy="empresa", fetch="LAZY")
     */
    private $usuarios;
    
    /**
     * Areas cadastradas para a empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Area", mappedBy="empresa", fetch="LAZY")
     */
    private $areas;	
    
    /**
     * Lista de cargos da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Cargo", mappedBy="empresa", fetch="LAZY")
     */
    private $cargos;
    
    /**
     * Lista de clientes da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Cliente", mappedBy="empresa", fetch="LAZY")
     */
    private $clientes;
    
    /**
     * Lista de status de atendimentos da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="StatusAtendimento", mappedBy="empresa", fetch="LAZY")
     */
    private $listaStatusAtendimento;
    
    /**
     * Lista de tipos de atendimentos da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="TipoAtendimento", mappedBy="empresa", fetch="LAZY")
     */
    private $listaTipoAtendimento;
    
    /**
     * Lista de atendimentos da empresa
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="empresa", fetch="LAZY")
     */
    private $atendimentos;
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="clienteEmpresarial", fetch="LAZY")
     * /
    private $solicitacoes;*/
    
    /**
     *
     * @var ArrayCollection
     * @OneToMany(targetEntity="DocumentoCliente", mappedBy="empresa", fetch="LAZY")
     */
    private $documentos;
    
    
    /**
     * Construtor
     */
    public function __construct(){
        $this->usuarios     = new ArrayCollection();
        $this->areas        = new ArrayCollection();        
        $this->cargos       = new ArrayCollection();
        $this->clientes     = new ArrayCollection();
        $this->listaStatusAtendimento   = new ArrayCollection();
        $this->listaTipoAtendimento     = new ArrayCollection();
        $this->atendimentos             = new ArrayCollection();
        $this->solicitacoes             = new ArrayCollection();
        $this->documentos               = new ArrayCollection();
        $this->setAdmin(false);
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
     * @var boolean
     * @Column(type="boolean", name="admin")
     */
    private $admin;
    
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
     * @Column(type="string", name="nome_fantasia", nullable=true)
     */
    private $nomeFantasia;
    
    /**
     *
     * @var string
     * @Column(type="string", name="cep", length=8, nullable=true)
     */
    private $cep;
    
    /**
     *
     * @var string
     * @Column(type="string", name="endereco", length=255, nullable=true)
     */
    private $endereco;
    
    /**
     *
     * @var string
     * @Column(type="string", name="bairro", length=120, nullable=true)
     */
    private $bairro;
    
    /**
     *
     * @var string
     * @Column(type="string", name="cidade", length=120, nullable=true)
     */
    private $cidade;
    
    /**
     *
     * @var string
     * @Column(type="string", name="estado", length=25, nullable=true)
     */
    private $estado;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=8, nullable=true)
     */
    protected $telefone;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=3, name="telefone_ddd", nullable=true)
     */
    protected $dddTelefone;
    
    /**
     *
     * @var string
     * @Column(type="string", length=255, name="email", nullable=true)
     */
    protected $email;
    
    /**
     *
     * @var string
     * @Column(type="string", length=255, name="logo", nullable=true)
     */
    protected $logo;
    
    
    function getUsuarios() {
        return $this->usuarios;
    }

    function getAreas() {
        return $this->areas;
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
    
    function getCep() {
        return $this->cep;
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

    function setCargos(ArrayCollection $cargos) {
        $this->cargos = $cargos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setCnpj($cnpj) {
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $this->cnpj = (empty($cnpj) ? null : $cnpj);        
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

    function setCep($cep) {
        $cep = preg_replace("/[^0-9]/", "", $cep);
        $this->cep = (empty($cep) ? null : $cep);
    }
        
    function setTelefone($telefone) {
        $telefone = preg_replace("/[^0-9]/", "", $telefone);
        $this->telefone = (empty($telefone) ? null : $telefone);
    }

    function setDddTelefone($dddTelefone) {
        $dddTelefone = preg_replace("/[^0-9]/", "", $dddTelefone);
        $this->dddTelefone = (empty($dddTelefone) ? null : $dddTelefone);        
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

    function getClientes() {
        return $this->clientes;
    }

    function getListaStatusAtendimento() {
        return $this->listaStatusAtendimento;
    }

    function getListaTipoAtendimento() {
        return $this->listaTipoAtendimento;
    }

    function getAtendimentos() {
        return $this->atendimentos;
    }

    function setClientes(ArrayCollection $clientes) {
        $this->clientes = $clientes;
    }

    function setListaStatusAtendimento(ArrayCollection $listaStatusAtendimento) {
        $this->listaStatusAtendimento = $listaStatusAtendimento;
    }

    function setListaTipoAtendimento(ArrayCollection $listaTipoAtendimento) {
        $this->listaTipoAtendimento = $listaTipoAtendimento;
    }

    function setAtendimentos(ArrayCollection $atendimentos) {
        $this->atendimentos = $atendimentos;
    }

    function isAdmin() {
        return $this->admin;
    }

    function setAdmin($admin) {
        $this->admin = (boolean) $admin;
    }

    function getSolicitacoes() {
        return $this->solicitacoes;
    }

    function setSolicitacoes(ArrayCollection $solicitacoes) {
        $this->solicitacoes = $solicitacoes;
    }
    
    function getResponsavel(){
        $usuarios = $this->getUsuarios();
        foreach($usuarios as $u){
            if($u->isAdministrador()){
                return $u;
            }
        }
    }
}
