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
    const COMENTARIO_CADASTRAR = 'comentario.cadastrar';
    
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
        
        $this->acl->addRole($atendente)
                    ->addRole($responsavelArea)
                    ->addRole($administrador);
        
        $atendimentoResource = new Resource('atendimento');
        $this->acl->addResource($atendimentoResource);
        
        $this->acl->allow(null, null, self::COMENTARIO_CADASTRAR, new ComentarAtendimentoAssertion());
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
