<?php

/**
 * @Entity
 * @Table(name="tb_usuario")
 */
class Usuario {
    
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