<?php

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Tests\ORM\Functional\Ticket\Entity;
use Symfony\Component\Console\Helper\Table;

/**
 * Description of TipoAtendimento
 *
 * @Entity
 * @Table(name="tb_ticket_tipo")
 */
class TipoAtendimento {
    
    /**
     * Lista de atendimentos com este tipo
     * 
     * @var ArrayCollection
     * @OneToMany(targetEntity="Atendimento", mappedBy="tipo")
     */
    private $atendimentos;
    
    /**
     * Construtor
     */
    function __construct() {
       $this->atendimentos = new ArrayCollection();
    }
    
    /**
     *
     * @var int
     * @Id
     * @GeneratedValue
     * @Column(type="integer", name="ticket_tipo_id")
     */
    private $id;
    
    /**
     *
     * @var string
     * @Column(type="string", length=100)
     */
    private $nome;
    
    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    private $descricao;
    
    
    function getAtendimentos() {
        return $this->atendimentos;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setAtendimentos(ArrayCollection $atendimentos) {
        $this->atendimentos = $atendimentos;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }


}
