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
}
