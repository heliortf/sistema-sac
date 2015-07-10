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
        $this->mailer->Username = 'effortsistemas@gmail.com';
        $this->mailer->Password = 'effortgoogle';
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
     * Envia um e-mail a partir do template original da effort
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
