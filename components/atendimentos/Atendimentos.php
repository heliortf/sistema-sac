<?php

/**
 * Realiza consultas de atendimentos
 *
 */
class Atendimentos {
    
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
        $query->setParameters($pDql);
        $query->setMaxResults($params['qtdPorPagina'])->setFirstResult($params['pagina']);
        $atendimentos = $query->getResult();
          
        $queryTotal = $em->createQuery("select count(*) as qtd $dql");
        $qtdArray = $queryTotal->getArrayResult();
        var_dump($qtdArray);
        return array(
            'registros' => $atendimentos,
            'paginacao' => array(
                'qtdRegistros'  => $qtdArray,
                'qtdPorPagina'  => $params['qtdPorPagina'],
                'pagina'        => $params['pagina'],
//                'qtdPaginas'    => ceil()
            )
        );
    }
}
