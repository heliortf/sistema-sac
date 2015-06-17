<?php


/**
 * Description of Empresas
 *
 * @author PONTOFRIO
 */
class Empresas {
    
    /**
     * Retorna a empresa administradora dos dados
     * 
     * @return Empresa
     */
    public function getAdmin(){
        $em = Conexao::getEntityManager();
        $Empresa = $em->createQuery("SELECT e FROM Empresa e WHERE e.admin = 1 ")
                        ->getSingleResult();
        
        return $Empresa;
    }
    
    /**
     * Retorna uma empresa a partir de determinados parametros
     * 
     * @param array $params
     */
    public function getEmpresa($params=array()){
        
    }
}
