<?php

/**
 * Realiza consultas de atendimentos
 *
 */
class Atendimentos {
    
	/**
	 * Consulta um atendimento pela id
	 *
	 * Parametros:
	 *	- Usuario $usuario
	 *  - int $id
	 *
	 * @param array $params
	 */
	public function getAtendimento($params=array()){
		$em = Conexao::getEntityManager();
		
		$u = $params['usuario'];
		
		$dql = "select a from Atendimento a WHERE a.empresa = :empresa AND a.id = :id ";
		$query = $em->createQuery($dql);
		$atendimentos = $query->setParameters(array(
			'empresa' 	=> $u->getEmpresa()->getId(),
			'id'		=> $params['id']
		))->getResult();
		
		if(count($atendimentos) == 1){
			return $atendimentos[0];
		}
		else {
			return false;
		}
	}
	
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
