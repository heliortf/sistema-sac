<?php

use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Classe de relatórios
 * 
 */
class Relatorios {

    function getQtdAtendimentosPorArea(Empresa $empresa) {
        $em = COnexao::getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('media', 'media_criacao')
                ->addScalarResult('nome_area', 'nome_area');

        $sql = "select 
                        count(t.atendimento_id) as qtd,
                    a.area_nome as nome_area,
                    s.nome as nome_status
                from 
                        tb_atendimento t
                        INNER JOIN tb_area a
                    ON a.area_id = t.tb_area_area_id
                    INNER JOIN tb_status_tipo s
                    ON s.status_tipo_id = t.tb_status_tipo_status_tipo_id
                WHERE
                    t.empresa_id = ?
                GROUP BY
                        t.tb_empresa_empresa_id, t.tb_area_area_id, t.tb_status_tipo_status_tipo_id
                ORDER BY 
                        t.tb_empresa_empresa_id, t.tb_area_area_id, t.tb_status_tipo_status_tipo_id";

        $medias = $em->createNativeQuery($sql, $rsm)
                ->setParameter(1, $empresa->getId())
                ->getResult();

        return $medias;
    }

    function getMediaSemanalCriacaoAtendimentosPorSetor(Empresa $empresa) {
        $em = COnexao::getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('media', 'media_criacao')
                ->addScalarResult('nome_area', 'nome_area');

        $sql = "select avg(qtd) as media, nome_area FROM (
                    select 
                            count(t.atendimento_id) as qtd,
                        a.area_nome as nome_area
                    from 
                            tb_atendimento t
                            INNER JOIN tb_area a
                        ON a.area_id = t.tb_area_area_id
                    WHERE
                        t.empresa_id = ?
                    GROUP BY
                            t.tb_empresa_empresa_id, t.tb_area_area_id, WEEK(t.data_criacao)
                    ) as tabela
                    ";

        $medias = $em->createNativeQuery($sql, $rsm)
                ->setParameter(1, $empresa->getId())
                ->getResult();

        return $medias;
    }

    function getAcessoDiarioSite(Empresa $empresa) {
        $em = Conexao::getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('qtd', 'qtd_acessos')
                ->addScalarResult('dia', 'dia');

        $sql = "SELECT                     
                    COUNT(a.acesso_id) as qtd, 
                    DATE_FORMAT(DATE(a.dataAcesso), '%d/%m/%Y') as dia
                FROM 
                    tb_acessos a 
                    INNER JOIN tb_empresa e
                    ON e.empresa_id = a.tb_empresa_empresa_id
                WHERE 
                    e.empresa_id = ? AND
                    a.dataAcesso > DATE_SUB(NOW(), INTERVAL 10 DAY)
                GROUP BY
                    a.tb_empresa_empresa_id, DATE(a.dataAcesso)
                ORDER BY a.dataAcesso DESC";

        $acessos = $em->createNativeQuery($sql, $rsm)
                ->setParameter(1, $empresa->getId())
                ->getResult();

        return $acessos;
    }

    function getAcessoSemanalSite(Empresa $empresa) {
        $em = Conexao::getEntityManager();

        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('qtd', 'qtd_acessos')
                ->addScalarResult('mes', 'mes')
                ->addScalarResult('semana', 'semana')
                ->addScalarResult('inicio_semana', 'inicio_semana')
                ->addScalarResult('fim_semana', 'fim_semana');

        $sql = "SELECT                     
                    COUNT(a.acesso_id) as qtd, 
                    MONTH(a.dataAcesso) as mes,
                    WEEK(a.dataAcesso) as semana,
                    DATE_FORMAT(
                        IF(STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Sunday'), '%X%V %W') < date_add(date_add(LAST_DAY(dataAcesso),interval 1 DAY),interval -1 MONTH), date_add(date_add(LAST_DAY(dataAcesso),interval 1 DAY),interval -1 MONTH), STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Sunday'), '%X%V %W'))                    
                    , '%d/%m/%Y') as inicio_semana,
                    
                    DATE_FORMAT(
                        IF(
                            IF(STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Saturday'), '%X%V %W') > LAST_DAY(dataAcesso), LAST_DAY(dataAcesso), STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Saturday'), '%X%V %W')) > CURDATE()
                            ,
                            CURDATE(),
                            IF(STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Saturday'), '%X%V %W') > LAST_DAY(dataAcesso), LAST_DAY(dataAcesso), STR_TO_DATE(CONCAT(YEAR(dataAcesso), WEEK(dataAcesso),' Saturday'), '%X%V %W'))
                        )
                    , '%d/%m/%Y') as fim_semana
                FROM 
                    tb_acessos a 
                    INNER JOIN tb_empresa e
                    ON e.empresa_id = a.tb_empresa_empresa_id
                WHERE 
                    e.empresa_id = ?
                GROUP BY
                    a.tb_empresa_empresa_id, MONTH(a.dataAcesso), WEEK(a.dataAcesso) 
                ORDER BY a.dataAcesso DESC";

        $acessos = $em->createNativeQuery($sql, $rsm)
                ->setParameter(1, $empresa->getId())
                ->getResult();

        return $acessos;
    }

    function getEmpresasCadastradas() {
        $em = Conexao::getEntityManager();
        $empresas = $em->createQuery("SELECT a FROM Empresa a WHERE a.admin = 0")
                ->getResult();

        return $empresas;
    }

    function getAtendimentosResolvidos($params = array()) {
        $em = Conexao::getEntityManager();
        $atendimentos = $em->createQuery("SELECT a FROM Atendimento a JOIN a.status s WHERE s.nome IN(:s1, :s2) AND a.empresa = :empresa")
                ->setParameter('s1', StatusAtendimento::STATUS_CONCLUIDO_E_AVALIADO)
                ->setParameter('s2', StatusAtendimento::STATUS_CONCLUIDO_NAO_AVALIADO)
                ->setParameter('empresa', $params['empresa']->getId())
                ->getResult();

        return $atendimentos;
    }

    function getSatisfacaoClientes($params = array()) {
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
