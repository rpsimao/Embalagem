<?php

class App_Mail_Create
{
   /**
     *
     * @return Zend_Mail_Transport_Smtp
     */
    
    
    private function setTransport ()
    {
        $this->config = Zend_Registry::get('mail_server');
        $this->params = array('auth' => 'login', 
        'username' => $this->config->username, 
        'password' => $this->config->password, 'ssl' => 'tls', 'port' => 25);
        $this->transport = new Zend_Mail_Transport_Smtp($this->config->ip_dns, 
        $this->params);
        return $this->transport;
    }
    
    
    /**
     *Define os valores do Boletim vindo do Optimus
     * @param array $params
     */
    public function setBoletimDetails (array $params)
    {
        $this->boldetails = $params;
    }
    /**
     *
     * @return multitype:
     */
    private function _getBolDetails ()
    {
        return $this->boldetails;
    }
    
    /**
     * Define para quem é enviado o email
     * @param array $name
     */
    
    public function setTo(array $name)
    {
        
        $this->name = $name;
        
    }
    
    
    private function _getTo()
    {
        return $this->name;
        
    }
    
    /**
     * Envia o email
     */
    public function sendMail ()
    {
        
        $names = $this->_getTo();
        $mail = new Zend_Mail($charset = 'UTF-8');
        $mail->setBodyHtml($this->_emailBody());
        $mail->setFrom('sysadmin@fterceiro.pt', 'System Admnistrator');
        $mail->addTo($names);
        $mail->setSubject("Foi criada uma nova Obra com Matéria Prima Certficada.");
        $mail->send($this->setTransport());
        
    }
    
    private function _emailBody ()
    {
        $time = Zend_Date::now()->toString('HH');
        $boletim = $this->_getBolDetails();
        $salut = ($time < 12) ? "Bom dia" : "Boa Tarde";
        $html = '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">' .
                $salut . "</p>";
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;">Foi criado no sistema uma nova Obra com Matéria Prima Certficada.</p>';
        $html .= '<p style="font-size:14px;font-family:Arial, Helvetica, Geneva, sans-serif;"><b><u>Detalhes:</u></b></p>';
        $html .= '<p style="font-size:12px;font-family:Arial, Helvetica, Geneva, sans-serif;"><b>Obra Nº: </b>' . $boletim['j_number'] . "<br>";
        $html .= '<b>Trabalho:</b> ' . utf8_encode($boletim['j_title1']) . " " . utf8_encode($boletim['j_title2']) . "<br>";
        $html .= '<b>Cliente: </b>' . $boletim['j_customer'] . "<br>";
        $html .= '<b>Data prevista de entrega:</b> ' . $boletim['j_deldate'] . "<br>";
        $html .= "</p>";
        $html .= '<br><p style="font-size:9px;font-family:Arial, Helvetica, Geneva, sans-serif;">Este é um email automático. Por favor não responda. Se achar que é engano por favor contacte o Administrador de sistemas.</p>';
       
        return $html;
    }
    
    
    
    
}
?>