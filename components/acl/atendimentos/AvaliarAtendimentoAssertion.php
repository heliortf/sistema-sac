<?php

use Zend\Permissions\Acl\Assertion\AssertionInterface;

/**
 * Description of RegistrarAtendimentoAssertion
 *
 * @author PONTOFRIO
 */
class AvaliarAtendimentoAssertion implements AssertionInterface {

    /**
     * Verifica se pode ou não registrar atendimento
     * 
     * @param \Zend\Permissions\Acl\Acl $acl
     * @param \Zend\Permissions\Acl\Role\RoleInterface $role
     * @param \Zend\Permissions\Acl\Resource\ResourceInterface $resource
     * @param type $privilege
     */
    public function assert(\Zend\Permissions\Acl\Acl $acl, \Zend\Permissions\Acl\Role\RoleInterface $role = null, \Zend\Permissions\Acl\Resource\ResourceInterface $resource = null, $privilege = null) {

        if ($resource instanceof Atendimento) {
            if ($role instanceof Usuario) {
                return false;
            }
            else if($role instanceof Cliente){
                // Se o atendimento é do cliente
                if($role->getId() == $resource->getCliente()->getId()){                 
                    // Verifica o status do atendimento
                    if ($resource->getStatus()->getNome() == StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO){
                        return true;
                    }                                            
                }
            }
        }
        return false;
    }

}
