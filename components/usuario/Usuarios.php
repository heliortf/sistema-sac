<?php

/**
 * Realiza os procedimentos no sistema referente a classe de usuarios
 * 
 */
class Usuarios {
    
    /**
     * 
     * @param array $params
     *          Usuario $usuario
     *          int $pagina
     *          int $qtdPorPagina
     */
    public function getLista($params=array()){
        $em = Conexao::getEntityManager();        
        
        $dql = "from Usuario u WHERE u.empresa = :empresa ";
        
        // Sempre vai pesquisar atendimentos empresa do usuario logado
        $pDql = array(
            'empresa' => $params['usuario']->getEmpresa()->getId()
        );
        
        // Se preencher a area
        if(isset($params['area']) && $params['area'] instanceof Area){
            $dql .= " AND u.area = :area ";
            $pDql['area'] = $params['area']->getId();
        }
        
        // Realiza a query limitada
        $usuarios = $em->createQuery("select u $dql")
                        ->setMaxResults($params['qtdPorPagina'])
                        ->setFirstResult($params['pagina'])
                        ->setParameters($pDql)
                        ->getResult();
        
        $queryTotal = $em->createQuery("select count(u.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                    ->getSingleScalarResult();        
        
        return array(
            'registros' => $usuarios,
            'paginacao' => array(
                'qtdRegistros'  => $qtd,
                'qtdPorPagina'  => $params['qtdPorPagina'],
                'pagina'        => $params['pagina'],
                'qtdPaginas'    => ceil($qtd / $params['qtdPorPagina'])
            )
        );        
    }
}
