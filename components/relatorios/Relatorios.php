<?php

/**
 * Classe de relatórios
 * 
 */
class Relatorios {
    
    function getAtendimentosResolvidos($params=array()){
        $em = Conexao::getEntityManager();
        $atendimentos = $em->createQuery("SELECT a FROM Atendimento a JOIN a.status s WHERE s.nome IN(:s1, :s2) AND a.empresa = :empresa")
                            ->setParameter('s1', StatusAtendimento::STATUS_CONCLUIDO_E_AVALIADO)
                            ->setParameter('s2', StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO)
                            ->setParameter('empresa', $params['empresa']->getId())
                            ->getResult();
        
        return $atendimentos;
    }
    
    function getSatisfacaoClientes($params=array()){
        $em = Conexao::getEntityManager();
        $clientes = $em->createQuery("SELECT c.id, c.nome, avg(a.avaliacao) as media_avaliacao, a.dataCriacao 
                          FROM Atendimento a JOIN a.cliente c 
                          WHERE a.empresa = :empresa
                          ORDER BY media_avaliacao DESC")
                ->setParameter('empresa', $params['empresa']->getId())
                ->getScalarResult();
        
        return $clientes;
    }
}
