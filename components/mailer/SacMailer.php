<?php

/**
 * Classe que realiza envio de e-mails no sistema
 *
 */
class SacMailer {
    
    /**
     * Empresa que enviará o e-mail
     * 
     * @var Empresa
     */
    private $empresa;
    
    /**
     * Classe de envio de e-mail
     * 
     * @var PHPMailer
     */
    private $mailer;
    
    /**
     * Inicializa o Mailer de acordo com os dados da empresa
     * 
     * @param Empresa $Empresa
     */
    public function __construct(Empresa $Empresa) {
        $this->empresa          = $Empresa;
        $this->mailer           = new PHPMailer();
        $this->mailer->From     = $Empresa->getEmail();
        $this->mailer->FromName = $Empresa->getNomeFantasia();
        $this->mailer->CharSet  = 'UTF-8';
        $this->mailer->Host     = 'imap.gmail.com';
        $this->mailer->Username = 'sigac@gmail.com';
        $this->mailer->Password = 'google';
//        $this->mailer->SMTPSecure = 'ssl';
        $this->mailer->Port     = 587;
        $this->mailer->SMTPAuth = true;
        $this->mailer->isSMTP();
    }
    
    public function getMailer(){
        return $this->mailer;
    }
    
    
    
    /**
     * Envia um e-mail
     * 
     * @param array $params
     * @return boolean
     */
    public function enviarEmail($params=array()){
        $this->mailer->clearAllRecipients();
        $this->mailer->Subject  = $params['subject'];
        $this->mailer->Body     = $params['body'];        
        
        foreach($params['to'] as $to){
            var_dump($to);
            $this->mailer->addAddress($to, "");
        }        
        
        $this->mailer->isHTML(true);
        return $this->mailer->send();
    }
    
    /**
     * Envia um e-mail a partir do template original da sigac
     * 
     * @param array $params
     *          string $url_logotipo
     *          string $mensagem
     *          string $subject
     */
    private function enviarEmailTemplate($params=array()){
        
        $template = file_get_contents(Config::$emailTemplatePath);
        
        $variaveis = array(
            '$nome_empresa$'    => $this->empresa->getNomeFantasia(),
            '$url_logotipo$'    => $params['url_logotipo'],
            '$mensagem$'        => $params['mensagem']
        );
        
        foreach($variaveis as $variavel => $valor){
            $template = str_replace($variavel, $valor, $template);
        }
        
        return $this->enviarEmail(array(
            'subject'   => "[ {$this->empresa->getNomeFantasia()} ] ".$params['subject'],
            'body'      => $template,
            'to'        => $params['to']
        ));
    }
    
    /**
     * 
     * @param array $params
     *          Cliente $cliente
     *          Atendimento $atendimento
     *          string $url_logotipo
     */
    public function enviarEmailInicioAtendimento($params=array()){
        
        $c = $params['cliente'];
        $a = $params['atendimento'];
        
        $s = 'Ol&aacute;, sr(a). <b>'.$c->getNome().'</b>.<br/><br/>';
        
        $s .= 'Informamos que seu atendimento de <b>n&ordm;'.$a->getId().'</b> foi registrado.<br/>';
        $s .= '<br/><br/>';
        $s .= "Seguem abaixo os dados do seu atendimento.<br/>";
        $s .= '<table style="width: 80%; margin: 10px auto;">';
        $s .= '<tbody>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Data cria&ccedil;&atilde;o:</b></td>';
        $s .=       '<td>'.$a->getDataCriacao()->format("d/m/Y H:i").'</td>';
        $s .=   '</tr>';        
        $s .=   '<tr>';
        $s .=       '<td align="right" width="25%"><b>Titulo:</b></td>';
        $s .=       '<td>'.$a->getTitulo().'</td>';
        $s .=   '</tr>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Tipo:</b></td>';
        $s .=       '<td>'.$a->getTipo()->getNome().'</td>';
        $s .=   '</tr>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Descri&ccedil;&atilde;o:</b></td>';
        $s .=       '<td>'.nl2br($a->getDescricao()).'</td>';
        $s .=   '</tr>';                
        $s .= '</tbody>';
        $s .= '</table>';
        $s .= "<br/><br/>";
        $s .= "Voc&ecirc; pode acessar este atendimento através do site abaixo: <br/><br/>";
        $s .= '<b>Site:</b> <a href="http://sigac.helioequipamentos.com.br/'.$this->empresa->getPermalink().'">http://sigac.helioequipamentos.com.br/'.$this->empresa->getPermalink().'</a><br/><br/>';
        $s .= "<b>Login:</b> {$c->getLogin()}<br/>";
        $s .= "<b>Senha:</b> {$c->getSenha()}<br/><br/><br/>";
        $s .= 'Atenciosamente,<br/>';
        $s .= '<b>SAC - '.$this->empresa->getNomeFantasia().'</b>';
        
        $to = array();
        if($c instanceof Cliente && $c->getEmail() != ""){
            $to[] = $c->getEmail();
        }
        
        return $this->enviarEmailTemplate(array(
            'subject'       => "Atendimento registrado",
            'mensagem'      => $s,
            'url_logotipo'  => $params['url_logotipo'],
            'to'            => $to
        ));
    }
    
    /**
     * 
     * @param array $params
     *          Cliente $cliente
     *          Atendimento $atendimento
     *          string $url_logotipo
     */
    public function enviarEmailComentarioAtendimento($params=array()){
        
        $c = $params['cliente'];
        $a = $params['atendimento'];
        
        $s = 'Ol&aacute;, sr(a). <b>'.$c->getNome().'</b>.<br/><br/>';
        
        $s .= 'Foi adicionado um comentario no seu atendimento de <b>n&ordm;'.$a->getId().'</b>.<br/>';
        $s .= '<br/><br/>';
        $s .= "Seguem abaixo os dados do seu atendimento.<br/>";
        $s .= '<table style="width: 80%; margin: 10px auto;">';
        $s .= '<tbody>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Data cria&ccedil;&atilde;o:</b></td>';
        $s .=       '<td>'.$a->getDataCriacao()->format("d/m/Y H:i").'</td>';
        $s .=   '</tr>';        
        $s .=   '<tr>';
        $s .=       '<td align="right" width="25%"><b>Titulo:</b></td>';
        $s .=       '<td>'.$a->getTitulo().'</td>';
        $s .=   '</tr>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Tipo:</b></td>';
        $s .=       '<td>'.$a->getTipo()->getNome().'</td>';
        $s .=   '</tr>';
        $s .=   '<tr>';
        $s .=       '<td align="right"  width="25%"><b>Descri&ccedil;&atilde;o:</b></td>';
        $s .=       '<td>'.nl2br($a->getDescricao()).'</td>';
        $s .=   '</tr>';                
        $s .= '</tbody>';
        $s .= '</table>';
        $s .= "<br/><br/>";
        $s .= "Voc&ecirc; pode acessar este atendimento através do site abaixo: <br/><br/>";
        $s .= '<b>Site:</b> <a href="http://sigac.helioequipamentos.com.br/'.$this->empresa->getPermalink().'">http://sigac.helioequipamentos.com.br/'.$this->empresa->getPermalink().'</a><br/><br/>';
        $s .= "<b>Login:</b> {$c->getLogin()}<br/>";
        $s .= "<b>Senha:</b> {$c->getSenha()}<br/><br/><br/>";
        $s .= 'Atenciosamente,<br/>';
        $s .= '<b>SAC - '.$this->empresa->getNomeFantasia().'</b>';
        
        $to = array();
        if($c instanceof Cliente && $c->getEmail() != ""){
            $to[] = $c->getEmail();
        }
        
        return $this->enviarEmailTemplate(array(
            'subject'       => "Atendimento registrado",
            'mensagem'      => $s,
            'url_logotipo'  => $params['url_logotipo'],
            'to'            => $to
        ));
    }
}
