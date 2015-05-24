<?php

/**
 * Realiza consultas de tipos de atendimentos
 *
 */
class TiposAtendimento {
    
	/**
	 * Consulta um tipo de atendimento pela id
	 *
	 * Parametros:
	 *	- Usuario $usuario
	 *  - int $id
	 *
	 * @param array $params
	 */
	public function getTipoAtendimento($params=array()){
		$em = Conexao::getEntityManager();
				
		$dql = "select a from TipoAtendimento a WHERE a.id = :id ";
		$query = $em->createQuery($dql);
		$atendimentos = $query->setParameters(array(			
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
     * - string $statusTipoAtendimento
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaTipoAtendimentos($params=array()){
        $em = Conexao::getEntityManager();
        
		$params['qtdPorPagina'] = (isset($params['qtdPorPagina']) ? $params['qtdPorPagina'] : 20);
		$params['pagina']		= (isset($params['pagina']) ? $params['pagina'] : 0);
		
        $dql = "from TipoAtendimento a ";
        
        $query = $em->createQuery("select a $dql");
        $atendimentos = $query->setMaxResults($params['qtdPorPagina'])
                                ->setFirstResult($params['pagina'])
                                ->getResult();
          
        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->getSingleScalarResult();        
        
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
    
    /**
     * Cadastra um atendimento no sistema
     * 
     * @param TipoAtendimento $atendimento
     * @return TipoAtendimento
     */
    public function salvar(TipoAtendimento $atendimento){
        $em = Conexao::getEntityManager();
        $em->persist($atendimento);
        $em->flush();
        return $atendimento;
    }
}
