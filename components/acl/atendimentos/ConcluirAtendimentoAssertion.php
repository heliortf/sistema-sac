<?php

use Zend\Permissions\Acl\Assertion\AssertionInterface;

/**
 * Description of RegistrarAtendimentoAssertion
 *
 * @author PONTOFRIO
 */
class ConcluirAtendimentoAssertion implements AssertionInterface {

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
                // Verifica o status do atendimento
                switch ($resource->getStatus()->getNome()) {
                    /**
                     * Se o atendimento estiver ABERTO
                     */
                    case StatusAtendimento::STATUS_ABERTO:
                        /**
                         * Verifica o cargo do usuario logado
                         */
                        switch ($role->getCargo()->getNome()) {
                            /**
                             * Se for atendente
                             */
                            case Cargo::ATENDENTE:
                                /**
                                 * Se o atendimento for da MESMA ÁREA do usuário, então pode comentar
                                 */
                                if($resource->getArea()->getId() == $role->getArea()->getId()){
                                    return true;
                                }                
                                /**
                                 * AREA DIFERENTE
                                 */
                                else {
                                    return false;
                                }
                                break;
                            /**
                             * Se for responsável da area. Não pode comentar
                             */
                            case Cargo::RESPONSAVEL_AREA:
                                return false;
                            case Cargo::ADMINISTRADOR:
                                return true;
                            default:
                                throw new Exception("Cargo não conhecido: ".$role->getCargo()->getNome());
                        }
                        break;
                    /**
                     * Se o atendimento estiver para ser analisado pelo responsável da Área
                     */
                    case StatusAtendimento::STATUS_ANALISE_AREA:
                        /**
                         * Verifica o cargo do usuario logado
                         */
                        switch ($role->getCargo()->getNome()) {
                            /**
                             * Se for atendente
                             */
                            case Cargo::ATENDENTE:                                
                                return false;
                                break;
                            /**
                             * Se for responsável da area. Não pode comentar
                             */
                            case Cargo::RESPONSAVEL_AREA:
                                /**
                                 * Se o atendimento for da MESMA ÁREA do usuário, então pode comentar
                                 */
                                if($resource->getArea()->getId() == $role->getArea()->getId()){
                                    return true;
                                }                
                                /**
                                 * AREA DIFERENTE
                                 */
                                else {
                                    return false;
                                }
                            case Cargo::ADMINISTRADOR:
                                return true;
                            default:
                                throw new Exception("Cargo não conhecido: ".$role->getCargo()->getNome());
                        }
                        break;
                    case StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO:
                    case StatusAtendimento::STATUS_CONCLUIDO_E_AVALIADO:
                        return false;
                    default:
                        throw new Exception("Status não identificado no atendimento: ".$resource->getStatus()->getNome());
                }
            }
        }
    }

}
