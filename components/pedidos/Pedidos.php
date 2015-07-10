<?php

/**
 * Realiza consultas de clientes
 *
 */
class Pedidos {

    /**
     * Retorna o cliente a partir de sua id
     * 
     * @param int $id
     * @return Pedido | boolean
     */
    public function getPedido($params=array()) {
        $em = Conexao::getEntityManager();
        
        $u = $params['usuario'];

        $dql = "select a from DocumentoCliente a WHERE a.empresa = :empresa AND a.id = :id ";
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
     * Retorna a lista de pedidos para o usuario logado
     * 
     * Parametros:
     * - Usuario $usuario
     * - string $text
     * - int $pagina
     * - in $qtdPorPagina
     * 
     * @param array $params
     */
    public function getListaPedidos($params = array()) {
        $em = Conexao::getEntityManager();

        $dql = "from DocumentoCliente c WHERE 1=1 ";

        $pDql = array();

        if (!empty($params['text'])) {
            $dql .= " AND ( c.titulo LIKE :text ) ";
            $pDql['text'] = $params['text'];
        }

        if ($params['usuario'] instanceof Usuario) {
            $dql .= " AND c.empresa = :empresa ";
            $pDql['empresa'] = $params['usuario']->getEmpresa()->getId();
        }

        $inicio = ($params['pagina'] - 1) * $params['qtdPorPagina'];
        
        $query = $em->createQuery("select c $dql");
        $pedidos = $query->setParameters($pDql)
                            ->setMaxResults($params['qtdPorPagina'])
                            ->setFirstResult($inicio)
                            ->getResult();

        $fim = $inicio + $params['qtdPorPagina'];

        if (count($pedidos) < $params['qtdPorPagina']) {
            $fim = $inicio + count($pedidos);
        }
        
        $queryTotal = $em->createQuery("select count(c.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                            ->getSingleScalarResult();

        return array(
            'registros' => $pedidos,
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

    public function salvar(DocumentoCliente $cliente) {
        $em = Conexao::getEntityManager();
        $em->persist($cliente);
        $em->flush();
    }

    public function excluir(DocumentoCliente $cliente) {
        $em = Conexao::getEntityManager();
        $em->remove($cliente);
        $em->flush();
    }	
}
