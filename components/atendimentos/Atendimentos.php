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
     * - int $pagina
     * - int $qtdPorPagina
     * 
     * [ Filtro por Atendimento ]
     * - int $statusAtendimento
     * - int $numeroAtendimento
     * - int $responsavelAtendimento
     *           
     * 
     * [ Filtro por Cliente ]
     * - string $nomeCliente
     * - string $cpfCnpjCliente
     * - string $emailCliente
     * 
     * [ Filtro por Período ]
     * - string $dataInicio
     * - sstring $dataFim
     * 
     * @param array $params
     */
    public function getListaAtendimentos($params=array()){
        $em = Conexao::getEntityManager();
        
        $dql = "from Atendimento a WHERE a.empresa = :empresa AND a.area = :area ";
        $pDql = array(
            'empresa'   => $params['usuario']->getEmpresa()->getId(),
            'area'      => $params['usuario']->getArea()->getId()
        );
        
        if(isset($params['numeroAtendimento']) && !empty($params['numeroAtendimento'])){
            $dql .= " AND a.id = :id ";
            $pDql['id'] = $params['numeroAtendimento'];
        }
        
        if(isset($params['statusAtendimento']) && !empty($params['statusAtendimento'])){
            $dql .= " AND a.status = :statusAtendimento ";
            $pDql['statusAtendimento'] = $params['statusAtendimento'];
        }
        
        if(isset($params['responsavelAtendimento']) && !empty($params['responsavelAtendimento'])){
            $dql .= " AND a.atendente = :responsavelAtendimento ";
            $pDql['responsavelAtendimento'] = $params['responsavelAtendimento'];
        }
        
        if(isset($params['nomeCliente']) && !empty($params['nomeCliente'])){
            // Verificar como faz o join com cliente
        }
        
        if(isset($params['cpfCnpjCliente']) && !empty($params['cpfCnpjCliente'])){
            // Verificar como faz o join com cliente
        }
        
        if(isset($params['emailCliente']) && !empty($params['emailCliente'])){
            // Verificar como faz o join com cliente
        }
        
        if(isset($params['dataInicio']) && !empty($params['dataInicio'])){
            $dql .= " AND a.dataCriacao >= :dataInicio ";
            $pDql['dataInicio'] = $params['dataInicio'];
        }
        
        if(isset($params['dataFim']) && !empty($params['dataFim'])){
            $dql .= " AND a.dataCriacao <= :dataFim ";
            $pDql['dataFim'] = $params['dataFim'];
        }
        
        $inicio = ($params['pagina'] - 1) * $params['qtdPorPagina'];
        
        $query = $em->createQuery("select a $dql");
        $atendimentos = $query->setParameters($pDql)
                                ->setMaxResults($params['qtdPorPagina'])
                                ->setFirstResult($inicio)
                                ->getResult();
        
        $fim = $inicio + $params['qtdPorPagina'];
        
        if(count($atendimentos) < $params['qtdPorPagina']){
            $fim = $inicio + count($atendimentos);
        }
          
        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                    ->getSingleScalarResult();        
        
        return array(
            'registros' => $atendimentos,
            'paginacao' => array(
                'qtdRegistros'  => $qtd,
                'qtdPorPagina'  => $params['qtdPorPagina'],
                'inicio'        => $inicio,
                'fim'           => $fim,
                'pagina'        => $params['pagina'],
                'qtdPaginas'    => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }
    
    /**
     * Cadastra um atendimento no sistema
     * 
     * @param Atendimento $atendimento
     * @return Atendimento
     */
    public function salvar(Atendimento $atendimento){
        $em = Conexao::getEntityManager();
        $em->persist($atendimento);
        $em->flush();
        return $atendimento;
    }
    
    /**
     * Cadastra um atendimento no sistema
     * 
     * @param Atendimento $atendimento
     * @return Atendimento
     */
    public function atualizar(Atendimento $atendimento){
        $em = Conexao::getEntityManager();
        $em->persist($atendimento);
        $em->flush();
        return $atendimento;
    }
	
	/**
	 * Salva o comentario em um determinado atendimento
	 * 
	 * @param ComentarioAtendimento $comentario
	 */
	public function salvarComentario(ComentarioAtendimento $comentario){
		$em = Conexao::getEntityManager();
		$em->persist($comentario);
		$em->flush();
		return $comentario;
	}
}
