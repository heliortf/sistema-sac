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
        $query = $em->createQuery('select u from Usuario u where u.login = :login AND u.senha = :senha');
        $query->setParameters(array(
            'login' => $params['login'],
            'senha' => $params['senha']
        ));
        
        $usuarios = $query->getResult();
        var_dump($usuarios); die("morreu");
        if(count($usuarios) == 1){
            return $usuarios[0];
        }
        else {
            return false;
        }
    }
}
