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
     * 	- Usuario $usuario
     *  - int $id
     *
     * @param array $params
     */
    public function getArea($params = array()) {
        $em = Conexao::getEntityManager();

        $u = $params['usuario'];

        $dql = "select a from Area a WHERE a.empresa = :empresa AND a.id = :id ";
        $pDql = array(
                    'empresa' => $u->getEmpresa()->getId(),
                    'id' => $params['id']
                );
        
        
        
        $query = $em->createQuery($dql);
        $areas = $query->setParameters($pDql)
                        ->getResult();

        if (count($areas) == 1) {
            return $areas[0];
        } else {
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
    public function getListaAreas($params = array()) {
        $em = Conexao::getEntityManager();

        $params['qtdPorPagina'] = isset($params['qtdPorPagina']) ? $params['qtdPorPagina'] : 100;
        $params['pagina'] = isset($params['pagina']) ? $params['pagina'] : 1;

        $dql = "from Area a WHERE a.empresa = :empresa ";
        $pDql = array(
            'empresa' => $params['usuario']->getEmpresa()->getId()
        );        
        
        if(isset($params['nome']) && !empty($params['nome'])){
            $dql .= " AND a.nome LIKE :nome";
            $pDql['nome'] = $params['nome'];
        }
        
        $inicio = ($params['pagina'] - 1) * $params['qtdPorPagina'];

        $query = $em->createQuery("select a $dql");
        $areas = $query->setParameters($pDql)
                ->setMaxResults($params['qtdPorPagina'])
                ->setFirstResult($inicio)
                ->getResult();
        
        $fim = $inicio + $params['qtdPorPagina'];

        if (count($areas) < $params['qtdPorPagina']) {
            $fim = $inicio + count($areas);
        }

        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                ->getSingleScalarResult();

        return array(
            'registros' => $areas,
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
     * Salva uma área no banco de dados
     * 
     * @param Area $area
     */
    public function salvar(Area $area){
        $em = Conexao::getEntityManager();
        $em->persist($area);
        $em->flush();
    }

}
