<?php

use Zend\Permissions\Acl\Acl;


/**
 * Configura o acesso
 *
 */
class SacACL {    
    
    /**
     * Inicializa as configurações
     * 
     * @see http://framework.zend.com/manual/current/en/modules/zend.permissions.acl.advanced.html
     */
    public function init(){
        $Acl = new Acl();
        $Acl->allow();
    }
}
