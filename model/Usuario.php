<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;
use Zend\Permissions\Acl\Role\RoleInterface;

/**
 * @Entity
 * @Table(name="tb_usuario")
 */
class Usuario implements RoleInterface {
    
    /**
     * Cargo do usuario
     * 
     * @var Cargo
     * @ManyToOne(targetEntity="Cargo", inversedBy="usuarios", fetch="LAZY")
     * @JoinColumn(name="tb_cargo_cargo_id", referencedColumnName="cargo_id")
     */
    protected $cargo;
    
    /**
     *
     * @var Perfil
     * @ManyToOne(targetEntity="Perfil", inversedBy="usuarios", fetch="LAZY")
     * @JoinColumn(name="tb_perfil_perfil_id", referencedColumnName="perfil_id")
     */
    protected $perfil;
    
    /**
     * Area que o usuário pertence
     *      
     * @var Area
     * @ManyToOne(targetEntity="Area", inversedBy="usuarios", fetch="LAZY")
     * @JoinColumn(name="tb_area_area_id", referencedColumnName="area_id")
     */
    protected $area;
    
    /**
     * Empresa que o usuario pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="usuarios", fetch="LAZY")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    protected $empresa;
    
    /**
     * Lista de atendimentos do usuario
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="atendente")
     */
    protected $meusAtendimentos;
    
    /**
     * Construtor
     */
    function __construct() {
        $this->meusAtendimentos = new ArrayCollection();
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
     * @Column(type="string", nullable=true)
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
     * @Column(type="string", length=11, nullable=true)
     */
    protected $cpf;
    
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
     * @Column(type="integer", length=9, nullable=true)
     */
    protected $celular;
    
    /**
     *
     * @var string
     * @Column(type="integer", length=3, name="celular_ddd", nullable=true)
     */
    protected $dddCelular;
    
 
    function getPerfil() {
        return $this->perfil;
    }

    function getMeusAtendimentos() {
        return $this->meusAtendimentos;
    }

    function setPerfil(Perfil $perfil) {
        $this->perfil = $perfil;
    }

    function setMeusAtendimentos(ArrayCollection $meusAtendimentos) {
        $this->meusAtendimentos = $meusAtendimentos;
    }
        
    function getCargo() {
        return $this->cargo;
    }

    function getArea() {
        return $this->area;
    }

    function getEmpresa() {
        return $this->empresa;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getLogin() {
        return $this->login;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getCpf() {
        return $this->cpf;
    }

    function getTelefone() {
        return $this->telefone;
    }

    function getDddTelefone() {
        return $this->dddTelefone;
    }

    function getCelular() {
        return $this->celular;
    }

    function getDddCelular() {
        return $this->dddCelular;
    }

    function setCargo( $cargo) {
        $this->cargo = $cargo;
    }

    function setArea( $area) {
        $this->area = $area;
    }

    function setEmpresa( $empresa) {
        $this->empresa = $empresa;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    function setDddTelefone($dddTelefone) {
        $this->dddTelefone = $dddTelefone;
    }

    function setCelular($celular) {
        $this->celular = $celular;
    }

    function setDddCelular($dddCelular) {
        $this->dddCelular = $dddCelular;
    }

    /**
     * Verifica se o usuario é um atendente
     * 
     * @return bool
     */
    public function isAtendente(){
        return ($this->getCargo()->getNome() == Cargo::ATENDENTE) ? true : false;
    }
    
    /**
     * Verifica se o usuário é um administrador
     * 
     * @return bool
     */
    public function isAdministrador(){
        return ($this->getCargo()->getNome() == Cargo::ADMINISTRADOR) ? true : false;
    }
    
    /**
     * Verifica se o usuário é responsável pela área
     * 
     * @return bool
     */
    public function isResponsavelArea(){
        return ($this->getCargo()->getNome() == Cargo::RESPONSAVEL_AREA) ? true : false;
    }
    
    /**
     * Retorna o roleid pro zend saber quem é
     * 
     * @return string
     */
    public function getRoleId() {
        return $this->getCargo()->getNome();
    }
}