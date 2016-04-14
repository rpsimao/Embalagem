<?php

class WebservicesController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->optimus = new App_User_Service_Optimus();
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction (){}

    /**
     * Web service para alerta da destruicao das chapas na folha de obra
     */
    public function edicaoAction ()
    {

        $numobra = $this->_getParam('id');
        $tipo    = $this->_getParam('tipo');

        if ($tipo == "06") {
            $jobData2 = $this->optimus->getJobInfo2($numobra);
            
            preg_match("/FT_[0-9]+/", $jobData2['sect_text'], $match);
            $NumericVal = preg_replace("/[^0-9]+/", "", $match[0]);
            
            $edition = (is_numeric($NumericVal)) ? substr($NumericVal, - 2) : null;
                   
            preg_match("/\/ [0-9]+/", $jobData2['sect_text'], $txt);
            
            str_replace(" ", "", $txt[0]);
            $noSlash = str_replace("/", "", $txt[0]);
            $getEdition = substr($noSlash, 1, 2);
            
            if ($tipo == "06" && $edition != "00" && $getEdition == "01") {
                
                $db = new App_User_Service_Frases();
                $frase = $db->findByID(1);
                
                echo $frase[0]['txt'];
            }
        }
    }

    /**
     * Web service para alerta alterar numero obra bluepharma
     */
	public function obrabluepharmaAction(){

		$numobra = $this->_getParam('j');


		$jobData2 = $this->optimus->getJobInfo2($numobra);


		preg_match("/\/ [0-9]+/", $jobData2['sect_text'], $txt);

		str_replace(" ", "", $txt[0]);
		$noSlash = str_replace("/", "", $txt[0]);
		$getEdition = substr($noSlash, 1, 2);

		if ($getEdition != "01") {

			$db = new App_User_Service_Frases();
			$frase = $db->findByID(2);

			echo $frase[0]['txt'];
		}

	}
    
    
    
    public function mailcertAction()
    {
       $jnumber = $this->_getParam('job');
        $job = $this->optimus->getJob($jnumber)->toArray();
        
        $mail = new App_Mail_Create();
        $mail->setBoletimDetails($job);
        $mail->setTo(array("Marta Cabral" => 'marta.cabral@fterceiro.pt'));
        $mail->sendMail();
    }


    public function getchapasrecuperadasAction()
    {
        $a = new App_Calculations_ChapasRecuperadas();
        $chapasRec = $a->calculateByYear();

        $this->getResponse()->appendBody(Zend_Json_Encoder::encode($chapasRec));


    }
}