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

        $dql = "select a from Cliente a WHERE a.empresa = :empresa ";
        $pDql = array(
            'empresa' => $u->getEmpresa()->getId()
        );
        
        if(isset($params['id']) && $params['id'] != ''){
            $dql .= " AND a.id = :id ";
            $pDql['id'] = $params['id'];
        }
        
        if(isset($params['cpf']) && $params['cpf'] != ''){
            $dql .= " AND a.cpf = :cpf ";
            $pDql['cpf'] = $params['cpf'];
        }
        
        $query = $em->createQuery($dql);
        $clientes = $query->setParameters($pDql)->getResult();        
        
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

        $inicio = ($params['pagina'] - 1) * $params['qtdPorPagina'];
        
        $query = $em->createQuery("select c $dql");
        $clientes = $query->setParameters($pDql)
                ->setMaxResults($params['qtdPorPagina'])
                ->setFirstResult($inicio)
                ->getResult();

        $fim = $inicio + $params['qtdPorPagina'];

        if (count($clientes) < $params['qtdPorPagina']) {
            $fim = $inicio + count($clientes);
        }
        
        $queryTotal = $em->createQuery("select count(c.id) as qtd $dql");
        $qtd = $queryTotal->setParameters($pDql)
                ->getSingleScalarResult();

        return array(
            'registros' => $clientes,
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

    public function salvar(Cliente $cliente) {
        $em = Conexao::getEntityManager();
        $em->persist($cliente);
        $em->flush();
    }

    public function excluir(Cliente $cliente) {
        $em = Conexao::getEntityManager();
        $em->remove($cliente);
        $em->flush();
    }	
}
