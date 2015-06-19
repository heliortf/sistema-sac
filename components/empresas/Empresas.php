<?php


/**
 * Description of Empresas
 *
 * @author PONTOFRIO
 */
class Empresas {
    
    /**
     * Retorna a empresa administradora dos dados
     * 
     * @return Empresa
     */
    public function getAdmin(){
        $em = Conexao::getEntityManager();
        $Empresa = $em->createQuery("SELECT e FROM Empresa e WHERE e.admin = 1 ")
                        ->getSingleResult();
        
        return $Empresa;
    }
    
    /**
     * Retorna uma empresa a partir de determinados parametros
     * 
     * @param array $params
     */
    public function getEmpresa($params=array()){
        $em = Conexao::getEntityManager();
        $Empresa = $em->find('Empresa', $params['id']);        
        return $Empresa;
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

        $dql = "from Empresa u WHERE u.admin = :admin ";

        // Sempre vai pesquisar atendimentos empresa do usuario logado
        $pDql = array(
            'admin' => false
        );

        // Se preencher o nome
        if (isset($params['nome']) && !empty($params['nome'])) {
            $dql .= " AND u.nomeFantasia LIKE :nome ";
            $pDql['nome'] = $params['nome'];
        }
        
        if(isset($params['permalink']) && !empty($params['permalink'])){
            $dql .= " AND u.permalink = :permalink ";
            $pDql['permalink'] = $params['permalink'];
        }

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
    
}
