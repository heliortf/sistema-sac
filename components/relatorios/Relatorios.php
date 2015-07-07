<?php

/**
 * Classe de relatórios
 * 
 */
class Relatorios {
    
    function getAtendimentosResolvidos(){
        $em = Conexao::getEntityManager();
        $atendimentos = $em->createQuery("SELECT a FROM Atendimento a JOIN a.cliente c WHERE a.status IN(:s1, :s2)")
                            ->setParameter(':s1', StatusAtendimento::STATUS_CONCLUIDO_E_AVALIADO)
                            ->setParameter(':s2', StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO)
                            ->getResult();
        
        return $atendimentos;
    }
}
