<?php


/**
 * Classe responsável por autenticar um usuário no sistema
 *
 */
class Autenticacao {
    
    
    /**
     * Autentica um usuário no sistema
     */
    public function autenticar($params=array()){
        $em = Conexao::getEntityManager();
        
        // Consulta para saber se encontra um usuario
        $query = $em->createQuery('select u from Usuario u where u.login = ?1 AND u.senha = ?2');
        $query->setParameters(array(
            1 => $params['login'],
            2 => $params['senha']
        ));                
        
        $usuarios = $query->getResult();
		
        if(count($usuarios) == 1){
            return $usuarios[0];
        }
        // Como não encontrou usuario, tenta encontrar o cliente
        else {            
            // Consulta o cliente
            $queryCliente = $em->createQuery("SELECT c FROM Cliente c WHERE c.login = ?1 AND c.senha = ?2");
            $queryCliente->setParameters(array(
                1 => $params['login'],
                2 => $params['senha']
            ));
            
            $clientes = $queryCliente->getResult();
            
            if(count($clientes) == 1){
                return $clientes[0];
            }
            else {
                return false;
            }
        }
    }
}
