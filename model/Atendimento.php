<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;
use Zend\Permissions\Acl\Resource\ResourceInterface;

/**
 * Description of Atendimento
 *
 * @Entity
 * @Table(name="tb_atendimento")
 */
class Atendimento implements ResourceInterface {

    /**
     * Empresa a que o atendimento pertence
     * 
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="atendimentos")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id")
     */
    private $empresa;

    /**
     * Cliente a que se refere o atendimento
     * 
     * @var Cliente
     * @ManyToOne(targetEntity="Cliente", inversedBy="atendimentos")
     * @JoinColumn(name="tb_cliente_cliente_id", referencedColumnName="cliente_id", nullable=true)
     */
    private $cliente;
    
    /**
     *
     * @var Empresa
     * @ManyToOne(targetEntity="Empresa", inversedBy="solicitacoes")
     * @JoinColumn(name="tb_empresa_empresa_id", referencedColumnName="empresa_id", nullable=true)
     */
    private $clienteEmpresarial;

    /**
     * Area onde o atendimento está
     * 
     * @var Area
     * @ManyToOne(targetEntity="Area", inversedBy="atendimentos")
     * @JoinColumn(name="tb_area_area_id", referencedColumnName="area_id")
     */
    private $area;

    /**
     * Usuário que está resolvendo o atendimento
     * 
     * @var Usuario
     * @ManyToOne(targetEntity="Usuario", inversedBy="meusAtendimentos")
     * @JoinColumn(name="tb_usuario_usuario_id", referencedColumnName="usuario_id", nullable=true)
     */
    private $atendente;

    /**
     *
     * @var StatusAtendimento
     * @ManyToOne(targetEntity="StatusAtendimento", inversedBy="atendimentos")
     * @JoinColumn(name="tb_status_tipo_status_tipo_id", referencedColumnName="status_tipo_id")
     */
    private $status;

    /**
     *
     * @var TipoAtendimento
     * @ManyToOne(targetEntity="TipoAtendimento", inversedBy="atendimentos")
     * @JoinColumn(name="tb_ticket_tipo_ticket_tipo_id", referencedColumnName="ticket_tipo_id")
     */
    private $tipo;

    /**
     * @var ArrayCollection
     * @OneToMany(targetEntity="ComentarioAtendimento", mappedBy="atendimento")
     */
    private $comentarios;

    /**
     * Construtor
     */
    function __construct() {
        $this->comentarios = new ArrayCollection();
    }

    /**
     * ID do atendimento
     * 
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="atendimento_id")
     */
    private $id;

    /**
     * Titulo do atendimento
     * 
     * @var string
     * @Column(type="string", name="titulo", length=255)
     */
    private $titulo;

    /**
     *
     * @var string
     * @Column(type="text", name="descricao", nullable=true)
     */
    private $descricao;

    /**
     * Conclusão do atendimento
     * 
     * @var string
     * @Column(type="text", name="conclusao", nullable=true)
     */
    private $conclusao;
    
    /**
     * Data de criação do atendimento
     * 
     * @var string
     * @Column(type="datetime", name="data_criacao")
     */
    private $dataCriacao;

    /**
     *
     * @var string
     * @Column(type="datetime", name="data_alteracao", nullable=true)
     */
    private $dataAlteracao;

    /**
     *
     * @var string
     * @Column(type="datetime", name="data_conclusao", nullable=true)
     */
    private $dataConclusao;

    /**
     *
     * @var string
     * @Column(type="string", length=100)
     */
    private $criadoPor;

    /**
     * 
     * @return Empresa
     */
    function getEmpresa() {
        return $this->empresa;
    }

    /**
     * 
     * @return Cliente
     */
    function getCliente() {
        return $this->cliente;
    }

    /**
     * 
     * @return Usuario
     */
    function getAtendente() {
        return $this->atendente;
    }

    function getComentarios() {
        return $this->comentarios;
    }

    function getComentariosPublicos() {
        $c = new ArrayCollection();
        foreach($this->comentarios as $cmt){
            if($cmt->isPublico()){
                $c[] = $cmt;
            }
        }
        return $c;
    }
    
    function getId() {
        return $this->id;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getDataCriacao() {
        return $this->dataCriacao;
    }

    function getDataAlteracao() {
        return $this->dataAlteracao;
    }

    function getDataConclusao() {
        return $this->dataConclusao;
    }

    function getCriadoPor() {
        return $this->criadoPor;
    }

    function setEmpresa(Empresa $empresa) {
        $this->empresa = $empresa;
    }

    function setCliente(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    function setAtendente($atendente) {
        $this->atendente = $atendente;
    }

    function setComentarios($comentarios) {
        $this->comentarios = $comentarios;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }

    function setDataAlteracao($dataAlteracao) {
        $this->dataAlteracao = $dataAlteracao;
    }

    function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
    }

    function setCriadoPor($criadoPor) {
        $this->criadoPor = $criadoPor;
    }

    function getArea() {
        return $this->area;
    }

    function setArea(Area $area) {
        $this->area = $area;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus(StatusAtendimento $status) {
        $this->status = $status;
    }

    function getTipo() {
        return $this->tipo;
    }

    function setTipo(TipoAtendimento $tipo) {
        $this->tipo = $tipo;
    }

    function getConclusao() {
        return $this->conclusao;
    }

    function setConclusao($conclusao) {
        $this->conclusao = $conclusao;
    }

    /**
     * Retorna a ID do atendimento como identificação de recurso
     * para o Zend ACL
     * 
     * @returns string
     */
    public function getResourceId() {
        return 'atendimento';
    }

    /**
     * Retorna o "Cliente-Empresa" da effort
     * 
     * @return Empresa
     */
    function getClienteEmpresarial() {
        return $this->clienteEmpresarial;
    }

    /**
     * Define o "Cliente-Empresa". Utilizado somente pela Effort
     * 
     * @param Empresa $clienteEmpresarial
     */
    function setClienteEmpresarial(Empresa $clienteEmpresarial) {
        $this->clienteEmpresarial = $clienteEmpresarial;
    }


}
