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
        $query = $em->createQuery('select u from Usuario u where u.login = ?1 AND u.senha = ?2');
        $query->setParameters(array(
            1 => $params['login'],
            2 => $params['senha']
        ));                
        
        $usuarios = $query->getResult();
		
        if(count($usuarios) == 1){
            return $usuarios[0];
        }
        else {
            return false;
        }
    }
}
