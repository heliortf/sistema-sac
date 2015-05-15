<?php

/**
 * Realiza consultas de atendimentos
 *
 */
class Atendimentos {
    
    /**
     * Retorna a lista de atendimentos para o usuario logado
     * 
     * Parametros:
     * - Usuario $usuario
     * - string $statusAtendimento
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaAtendimentos($params=array()){
        $em = Conexao::getEntityManager();
        
        $dql = "from Atendimento a WHERE a.area = :area ";
        $pDql = array(
            'area' => $params['usuario']->getArea()->getId()
        );
        
        $query = $em->createQuery("select a $dql");
        $atendimentos = $query->setParameters($pDql)
                                ->setMaxResults($params['qtdPorPagina'])
                                ->setFirstResult($params['pagina'])
                                ->getResult();
          
        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                    ->getSingleScalarResult();        
        
        return array(
            'registros' => $atendimentos,
            'paginacao' => array(
                'qtdRegistros'  => $qtd,
                'qtdPorPagina'  => $params['qtdPorPagina'],
                'pagina'        => $params['pagina'],
                'qtdPaginas'    => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }
}
