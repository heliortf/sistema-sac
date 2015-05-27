<?php

use Zend\Permissions\Acl\Assertion\AssertionInterface;


/**
 * Description of RegistrarAtendimentoAssertion
 *
 * @author PONTOFRIO
 */
class RegistrarAtendimentoAssertion implements AssertionInterface {
    /**
     * Verifica se pode ou não registrar atendimento
     * 
     * @param \Zend\Permissions\Acl\Acl $acl
     * @param \Zend\Permissions\Acl\Role\RoleInterface $role
     * @param \Zend\Permissions\Acl\Resource\ResourceInterface $resource
     * @param type $privilege
     */
    public function assert(\Zend\Permissions\Acl\Acl $acl, 
                            \Zend\Permissions\Acl\Role\RoleInterface $role = null, 
                            \Zend\Permissions\Acl\Resource\ResourceInterface $resource = null, 
                            $privilege = null) {
        
         
    }
}
