<?php

/**
 * Realiza consultas de clientes
 *
 */
class Clientes {

    /**
     * Retorna o cliente a partir de sua id
     * 
     * @param int $id
     * @return Cliente | boolean
     */
    public function getCliente($params=array()) {
        $em = Conexao::getEntityManager();
        
        $u = $params['usuario'];

        $dql = "select a from Cliente a WHERE a.empresa = :empresa AND a.id = :id ";
        $query = $em->createQuery($dql);
        $clientes = $query->setParameters(array(
            'empresa' => $u->getEmpresa()->getId(),
            'id' => $params['id']
        ))->getResult();

        if (count($clientes) == 1) {
            return $clientes[0];
        } else {
            return false;
        }
    }

    /**
     * Retorna a lista de clientes para o usuario logado
     * 
     * Parametros:
     * - Usuario $usuario
     * - string $text
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaClientes($params = array()) {
        $em = Conexao::getEntityManager();

        $dql = "from Cliente c WHERE 1=1 ";

        $pDql = array();

        if (!empty($params['text'])) {
            $dql .= " AND ( c.nome LIKE :text OR c.cpf LIKE :text ) ";
            $pDql['text'] = $params['text'];
        }

        if ($params['usuario'] instanceof Usuario) {
            $dql .= " AND c.empresa = :empresa ";
            $pDql['empresa'] = $params['usuario']->getEmpresa()->getId();
        }

        $query = $em->createQuery("select c $dql");
        $clientes = $query->setParameters($pDql)
                ->setMaxResults($params['qtdPorPagina'])
                ->setFirstResult($params['pagina'])
                ->getResult();

        $queryTotal = $em->createQuery("select count(c.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                ->getSingleScalarResult();

        return array(
            'registros' => $clientes,
            'paginacao' => array(
                'qtdRegistros' => $qtd,
                'qtdPorPagina' => $params['qtdPorPagina'],
                'pagina' => $params['pagina'],
                'qtdPaginas' => ceil($qtd / $params['qtdPorPagina'])
            )
        );
    }

    public function salvar(Cliente $cliente) {
        
    }

}
