<?php

/**
 * Realiza consultas de cargos
 *
 */
class Cargos {

    /**
     * Consulta um cargo pela id
     *
     * Parametros:
     * 	- Usuario $usuario
     *  - int $id
     *
     * @param array $params
     */
    public function getCargo($params = array()) {
        $em = Conexao::getEntityManager();

        $u = $params['usuario'];

        $dql = "select a from Cargo a WHERE a.empresa = :empresa AND a.id = :id ";
        $query = $em->createQuery($dql);
        $cargos = $query->setParameters(array(
                    'empresa' => $u->getEmpresa()->getId(),
                    'id' => $params['id']
                ))->getResult();

        if (count($cargos) == 1) {
            return $cargos[0];
        } else {
            return false;
        }
    }

    /**
     * Retorna a lista de cargos para o usuario logado
     * 
     * Parametros:
     * - Usuario $usuario
     * - string $statusCargo
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaCargos($params = array()) {
        $em = Conexao::getEntityManager();

        $params['qtdPorPagina'] = isset($params['qtdPorPagina']) ? $params['qtdPorPagina'] : 100;
        $params['pagina'] = isset($params['pagina']) ? $params['pagina'] : 0;

        $dql = "from Cargo a WHERE a.empresa = :empresa ";
        $pDql = array(
            'empresa' => $params['usuario']->getEmpresa()->getId()
        );

        $query = $em->createQuery("select a $dql");
        $cargos = $query->setParameters($pDql)
                ->setMaxResults($params['qtdPorPagina'])
                ->setFirstResult($params['pagina'])
                ->getResult();

        $queryTotal = $em->createQuery("select count(a.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                ->getSingleScalarResult();

        return array(
            'registros' => $cargos,
            'paginacao' => array(
                'qtdRegistros' => $qtd,
                'qtdPorPagina' => $params['qtdPorPagina'],
                'pagina' => $params['pagina'],
                'qtdPaginas' => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }

}
