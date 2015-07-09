<?php

/**
 * Realiza os procedimentos no sistema referente a classe de usuarios
 * 
 */
class Usuarios {

    /**
     * Consulta um usuario pela id
     * 
     * @param array $params
     * @return boolean
     */
    public function getUsuario($params = array()) {
        $em = Conexao::getEntityManager();

        $dql = "select a from Usuario a WHERE a.id = :id ";
        $pDql = array('id' => $params['id']);
        
        if(isset($params['usuario'])){
            $dql .= " AND a.empresa = :empresa ";
            $pDql['empresa'] = $params['usuario']->getEmpresa()->getId();
        }
        
        if(isset($params['empresa'])){
            $dql .= " AND a.empresa = :empresa";
            $pDql['empresa'] = $params['empresa']->getId();
        }
        
        $query = $em->createQuery($dql);
        $usuarios = $query->setParameters($pDql)->getResult();

        if (count($usuarios) == 1) {
            return $usuarios[0];
        } else {
            return false;
        }
    }

    /**
     * 
     * @param array $params
     *          Usuario $usuario
     *          int $pagina
     *          int $qtdPorPagina
     */
    public function getLista($params = array()) {
        $em = Conexao::getEntityManager();

        $dql = "from Usuario u WHERE u.empresa = :empresa ";

        // Sempre vai pesquisar atendimentos empresa do usuario logado
        $pDql = array(
            'empresa' => $params['usuario']->getEmpresa()->getId()
        );

        // Se preencher a area
        if (isset($params['area']) && $params['area'] instanceof Area) {
            $dql .= " AND u.area = :area ";
            $pDql['area'] = $params['area']->getId();
        }

        // Se preencher o nome
        if (isset($params['nome']) && !empty($params['nome'])) {
            $dql .= " AND u.nome LIKE :nome ";
            $pDql['nome'] = $params['nome'];
        }
        
        $dql .= " ORDER BY u.nome ";

        $inicio = ($params['pagina'] - 1) * $params['qtdPorPagina'];

        // Realiza a query limitada
        $usuarios = $em->createQuery("select u $dql")
                ->setMaxResults($params['qtdPorPagina'])
                ->setFirstResult($inicio)
                ->setParameters($pDql)
                ->getResult();

        $fim = $inicio + $params['qtdPorPagina'];

        if (count($usuarios) < $params['qtdPorPagina']) {
            $fim = $inicio + count($usuarios);
        }

        $queryTotal = $em->createQuery("select count(u.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                ->getSingleScalarResult();

        return array(
            'registros' => $usuarios,
            'paginacao' => array(
                'qtdRegistros' => $qtd,
                'qtdPorPagina' => $params['qtdPorPagina'],
                'inicio' => $inicio,
                'fim' => $fim,
                'pagina' => $params['pagina'],
                'qtdPaginas' => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }
    
    /**
     * Cadastra um usuario no sistema
     * 
     * @param Usuario $u
     */
    public function salvar(Usuario $u){
        $em = Conexao::getEntityManager();
        $em->persist($u);
        $em->flush();
    }

    /**
     * Verifica a existencia de um login no sistema
     * 
     * @param array $params
     *          Usuario $usuario -> usuario logado
     *          string $login -> login a ser verificado
     *          int $id -> ( opcional ) id do usuario ou id do cliente
     */
    public function existeLogin($params=array()){
        $em = Conexao::getEntityManager();
        
        $dql    = "select count(u.id) as qtd from Usuario u WHERE u.login = :login AND u.empresa = :empresa ";
        $pDql   = array(
            'empresa'   => $params['usuario']->getEmpresa()->getId(),
            'login'     => $params['login']
        );
        
        if(isset($params['id']) && !empty($params['id']) && $params['tipo'] == 'usuario'){
            $dql .= " AND u.id <> :id ";
            $pDql['id'] = $params['id'];
        }
        
        $qtdUsuarios = $em->createQuery($dql)
                    ->setParameters($pDql)
                    ->getSingleScalarResult();        
        
        if($qtdUsuarios > 0){
            return true;
        }
        else {
		
			$dql2 = "select count(u.id) as qtd from Cliente u WHERE u.login = :login AND u.empresa = :empresa ";
			$pDql2   = array(
				'empresa'   => $params['usuario']->getEmpresa()->getId(),
				'login'     => $params['login']
			);
		
				
			if(isset($params['id']) && !empty($params['id']) && $params['tipo'] == 'cliente'){
				$dql2 .= " AND u.id <> :id ";
				$pDql2['id'] = $params['id'];
			}
        
			$qtdClientes = $em->createQuery($dql)
							->setParameters($pDql)
							->getSingleScalarResult();        
        
			return $qtdClientes > 0 ? true : false;
        }
    }
}
