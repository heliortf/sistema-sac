<?php

/**
 * Realiza consultas de areas
 *
 */
class Areas {
    
	/**
	 * Consulta um area pela id
	 *
	 * Parametros:
	 *	- Usuario $usuario
	 *  - int $id
	 *
	 * @param array $params
	 */
	public function getArea($params=array()){
		$em = Conexao::getEntityManager();
		
		$u = $params['usuario'];
		
		$dql = "select a from Area a WHERE a.empresa = :empresa AND a.id = :id ";
		$query = $em->createQuery($dql);
		$areas = $query->setParameters(array(
			'empresa' 	=> $u->getEmpresa()->getId(),
			'id'		=> $params['id']
		))->getResult();
		
		if(count($areas) == 1){
			return $areas[0];
		}
		else {
			return false;
		}
	}
	
    /**
     * Retorna a lista de areas para o usuario logado
     * 
     * Parametros:
     * - Usuario $usuario
     * - string $statusArea
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaAreas($params=array()){
        $em = Conexao::getEntityManager();
        
        $dql = "from Area a WHERE a.empresa = :empresa ";
        $pDql = array(
            'empresa' => $params['usuario']->getEmpresa()->getId()
        );
        
        $query = $em->createQuery("select a $dql");
        $areas = $query->setParameters($pDql)
                                ->setMaxResults($params['qtdPorPagina'])
                                ->setFirstResult($params['pagina'])
                                ->getResult();
          
        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                    ->getSingleScalarResult();        
        
        return array(
            'registros' => $areas,
            'paginacao' => array(
                'qtdRegistros'  => $qtd,
                'qtdPorPagina'  => $params['qtdPorPagina'],
                'pagina'        => $params['pagina'],
                'qtdPaginas'    => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }
}
