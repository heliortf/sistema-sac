<?php

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;


/**
 * Configura o acesso
 *
 */
class SacACL {    
    /**
     * Define o ID da ação
     */
    const ATENDIMENTO_COMENTAR      = 'atendimento.comentar';
    const ATENDIMENTO_ENCAMINHAR    = 'atendimento.encaminhar';
    const ATENDIMENTO_CONCLUIR      = 'atendimento.concluir';
    const ATENDIMENTO_AVALIAR       = 'atendimento.avaliar';
    
    /**
     *
     * @var SacACL
     */
    private static $instance = null;
    
    /**
     *
     * @var Acl
     */
    private $acl = null;
    
    /**
     * Construtor
     */
    private function __construct(){      
        $this->init();
    }
    
    /**
     * Retorna a instancia do objeto
     * 
     * @return SacACL
     */
    public static function getInstance(){
        if(self::$instance == null){
            self::$instance = new SacACL();
        }
        return self::$instance;
    }
    
    /**
     * Inicializa as configurações
     * 
     * @see http://framework.zend.com/manual/current/en/modules/zend.permissions.acl.advanced.html
     */
    private function init(){
        $this->acl = new Acl();
        
        $atendente          = new Role('atendente');
        $responsavelArea    = new Role('responsavel_area');
        $administrador      = new Role('administrador');
        $cliente            = new Role('cliente');
        
        $this->acl->addRole($atendente)
                    ->addRole($responsavelArea)
                    ->addRole($administrador)
                    ->addRole($cliente);
        
        $atendimentoResource = new Resource('atendimento');
        $this->acl->addResource($atendimentoResource);
        
        $this->acl->allow(null, null, self::ATENDIMENTO_COMENTAR, new ComentarAtendimentoAssertion());
        $this->acl->allow(null, null, self::ATENDIMENTO_ENCAMINHAR, new EncaminharAtendimentoAssertion());
        $this->acl->allow(null, null, self::ATENDIMENTO_CONCLUIR, new ConcluirAtendimentoAssertion());
        $this->acl->allow(null, null, self::ATENDIMENTO_AVALIAR, new AvaliarAtendimentoAssertion());
    }
    
    /**
     * Verifica se é permitido
     * 
     * @param string $role
     * @param string $resource
     * @param string $privilege
     * @return boolean
     */
    public function isAllowed($role=null, $resource=null, $privilege=null){
        return $this->acl->isAllowed($role, $resource, $privilege);
    }
}
