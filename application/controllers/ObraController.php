<?php

/**
 *Controller para criar o selo das provas de embalagem
 *
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 27/03/2014
 */
class ObraController extends Zend_Controller_Action
{

    protected $optimus;
    protected $job;
    protected $form;
    protected $cartolina;

    /**
     * Inicializa as variáveis de conexão às tabelas das bases de dados.
     */
    public function init ()
    {

        if ($this->_helper->FlashMessenger->hasMessages()) {
        $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        
        $this->optimus   = new App_User_Service_Optimus();
        $this->job       = new App_User_Service_Obras();
        $this->form      = new App_Forms_Obra();
        $this->cartolina = new App_User_Service_Cartolina();
        
    }

    public function preDispatch ()
    {
        $this->_helper->layout()->setLayout('layout-iso');
        $this->view->setEscape('stripslashes');
        
    }

    /**
     * Se já existir a obra na base de dados da embalagem, recupera os valores, caso contrário liga-se ao Optimus e recupera os valores através do número da obra
     * @return Zend_Form
     */
    public function indexAction ()
    {
        if ($this->getRequest()->isPost()){
            $numobra = $this->_request->getPost('numobra');
        } else {
            $numobra = $this->_getParam('id');
            
            
        }
        
        $jobData1 = $this->optimus->getJobInfo1($numobra);
        $jobData2 = $this->optimus->getJobInfo2($numobra);


        
        if ($this->checkJobNumber($numobra) == 0) {
            $jobData = $this->optimus->getJobData($numobra);
            
            $stringSearch = new App_Calculations_StringSearch();
            $stringSearch->setContents($jobData1['sect_text']);
            
            
           
            $stringSearch->setString1('Formato fechado: ');
            $stringSearch->setString2('mm.');
		    $formato = $stringSearch->regExpSearch();
		    
		   

		    $stringSearch->setString1('Cores');
		    $stringSearch->setString2('Acabamentos:');
		    $braille    = $stringSearch->search1RegularExpr('brai');
		    $vernizAgua = $stringSearch->search1RegularExpr("gua");
		    $estampagem = $stringSearch->search1RegularExpr("stampagem");
		    $vernizuv   = $stringSearch->search2RegularExpr("uv", "u.v");
		    $relevo     = $stringSearch->search1RegularExpr("elevo");
		    
		    
		    $stringSearch->setString1('Acabamentos');
		    $stringSearch->setString2('Cliente:');
		    $plastificacao = $stringSearch->search1RegularExpr('lastifica');
		    
		    
		    $stringSearch->setString1('Cartolina:');
		    $stringSearch->setString2('Cores');
		    $stringCarton = $stringSearch->search();
		    $carton = $stringSearch->filterCarton($stringCarton);
		    
		    if (preg_match('/[PE]/i', $carton)) {
		    
		        $explode = explode('/', $carton);
		        $espessura = $this->cartolina->getEspessuraPE($explode[0]);
		    
		    } else {
		    
		        $cleancarton = str_replace('g', '', $carton);
		        $explode = explode('/', $cleancarton);
		    
		        $espessura = $this->cartolina->getEspessura($explode[0], $explode[1]);
		    }

            $subject = $jobData2['sect_text'];
		    
		    $stringSearch->setContents($jobData2['sect_text']);
		    
		    $stringSearch->setString1('Picote');
		    $stringSearch->setString2('Clich');
		    $stringSearch->regExpSearch();
		    $picote = $stringSearch->search1RegularExpr("sim\[x\]");
			
            $pattern = "/Leatus:[^0-9a-zA-Z][0-9]+/";

            preg_match($pattern, $subject, $matches);
            $laetus = preg_replace("/[^0-9 ]/", '', $matches[0]);


            /**
             * NOVO algoritmo para sacar o Cod F3
             */

            $pattern1 = '/FT_[A-Za-z0-9]+/';
            $pattern2 = '/FT:[A-Za-z0-9 ]+/i';


            preg_match($pattern1, $subject, $matches);

            $result = ($matches) ? substr($matches[0], 0, 3) : null;


            switch ($result) {
                case 'FT_':
                    $codf3 = str_ireplace("FT_", "", $matches[0]);

                    break;

                case null:
                    preg_match($pattern2, $subject, $matches);

                    if ($matches)
                    {
                        $codf3 = str_ireplace("FT:", "", $matches[0]);
                        $codf3 = str_replace(" ", "", $codf3);
                    } else {
                        $codf3 =  null;
                    }
                    break;

                default:
                    $codf3 =  null;
                    break;
            }

            $stringSearch->setString1('Maq[');
            $stringSearch->setString2(']  Agua');
            $stringVerniz = $stringSearch->search();
            $verniz = ($stringVerniz == "X" || $stringVerniz == "x") ? "Sim" : "Nao";
            
            if ($stringVerniz == "")
            {
                $stringSearch->setString1('Verniz:');
                $stringSearch->setString2('Subcontratos');
                $stringVerniz = $stringSearch->search();
            
                $stringVerniz = substr($stringVerniz, 0, 3);
                $stringVerniz = strtolower($stringVerniz);
            
                if ($stringVerniz == "sim")
                {
                    $verniz = "Sim";
                } else {
                    $verniz = $stringSearch->search1RegularExpr('verniz');
                }
            }
            

            preg_match("'cores(.*?)verniz'si", $jobData2['sect_text'], $match);
            $ccc = str_replace(':', '', $match[1]);
            $ccc = str_replace(' ', '', $ccc);
            $ccc = str_replace(',', '+', $ccc);
            $ccc = str_replace('/', '+', $ccc);
            $ccc = str_replace("\t", '', $ccc);
            
            
            /**
             * EDIÇÃO
             */
            $pattern = "/[0-9]+_[0-9]+/";

            preg_match($pattern, $subject, $matches);

            $edicao = explode("_",$matches[0]);
            
              
            
            $params = array(
                'numobra'       => $numobra , 
                'cliente'       => htmlentities($jobData['j_customer']) , 
                'produto'       => htmlentities($jobData['j_title1']) , 
                'codproduto'    => htmlentities($jobData['j_title2']) ,
                'formato'       => str_replace("*", 'x',$formato),
                'codf3'         => $codf3,
                'numcores'      => App_Service_Cleaners_Colors::stringClean(substr($ccc, 0, -1)),
                'edicao'        => $edicao[0],
                'vernizmaq'     => $this->translateCheckboxes($verniz) ,
                'braille'       => $this->translateCheckboxes($braille) ,
               // 'codvisual'     => $plastificacao,
                'codlaetus'     => $laetus,
                'cartolina'     => $carton,
                'espessura'     => $espessura['espessura'],
            	'vernizagua'    => $this->translateCheckboxes($vernizAgua) ,
                'picote'        => $this->translateCheckboxes($picote) ,
                'estampagem'    => $this->translateCheckboxes($estampagem) ,
                'vernizuv'      => $this->translateCheckboxes($vernizuv) ,
                'relevo'        => $this->translateCheckboxes($relevo) ,
                'plastificacao' => $this->translateCheckboxes($plastificacao) ,
            );
            
            
            
            
        } else {
            $values = $this->job->getValues($numobra);
            
            $params = array(
                'numobra'       => $numobra , 
                'cliente'       => $values['cliente'] , 
                'produto'       => $values['produto'] , 
                'formato'       => $values['formato'] , 
                'edicao'        => $values['edicao'] , 
                'cartolina'     => $values['cartolina'] , 
                'espessura'     => $values['espessura'] , 
                'codproduto'    => $values['codproduto'] , 
                'codlaetus'     => $values['codlaetus'] , 
                'codvisual'     => $values['codvisual'] , 
                'codf3'         => $values['codf3'] , 
                'numcores'      => $values['numcores'] , 
                'vernizmaq'     => $this->translateCheckboxes($values['vernizmaq']) , 
                'vernizuv'      => $this->translateCheckboxes($values['vernizuv']) , 
                'vernizagua'    => $this->translateCheckboxes($values['vernizagua']) ,
                'plastificacao' => $this->translateCheckboxes($values['plastificacao']) ,
                'estampagem'    => $this->translateCheckboxes($values['estampagem']) ,
                'braille'       => $this->translateCheckboxes($values['braille']) ,
                'picote'        => $this->translateCheckboxes($values['picote']) ,
                'relevo'        => $this->translateCheckboxes($values['relevo']) , 
                'prova'         => $values['prova']);
        }
        
        
        if ($this->_getParam('tipo') == 'optimus')
        {
            $logger = new Zend_Log();
            $writer = new Zend_Log_Writer_Firebug();
            $logger->addWriter($writer);
            
            if ($this->checkJobNumber($numobra) == 0) {
            
                $this->job->insertObra( $numobra,
                htmlentities($jobData['j_customer']),
                htmlentities($jobData['j_title1']),
                str_replace("*", 'x',$formato),
                $edicao,
                $carton,
                $espessura['espessura'],
                htmlentities($jobData['j_title2']),
                $laetus,
                "",
                $codf3,
                App_Service_Cleaners_Colors::stringClean(substr($ccc, 0, -1)),
                $verniz,
                $vernizuv,
                $vernizAgua,
                $plastificacao,
                $estampagem,
                $braille,
                $picote,
                $relevo,
                "");
                
                $logger->log('Dados inseridos com sucesso.', Zend_Log::INFO);
                $this->_helper->viewRenderer->setNoRender();
                $this->_helper->layout->disableLayout();
                
            } else {
                $this->_helper->viewRenderer->setNoRender();
                $this->_helper->layout->disableLayout();
                
               $logger->log('Obra ' . $numobra .' ja existe.', Zend_Log::INFO);
            }
            
           
        
        } else {
        
            $this->view->form = $this->form->populate($params);
            $this->view->info1 = $jobData1['sect_text'];
            $this->view->info2 = $jobData2['sect_text'];
            $this->view->numobra = $numobra;
        }
    }

    /**
     * Confirma se a obra já existe na base de dados da embalagem
     * @param int $numObra
     * @return int
     */
    private function checkJobNumber ($numObra)
    {

        try {
            $check = new App_User_Service_Obras();
            $values = $check->getValues($numObra);
            $exists = count($values);
            return $exists;
        } catch (Zend_Exception $e) {
            return 0;
        }
    }

    /**
     * 
     * Transforma Sim ou Não em 0 ou 1
     * @param string $value
     * @return int
     */
    private function translateCheckboxes ($value)
    {

        $number = ($value == 'Sim') ? 1 : 0;
        return $number;
    }

    /**
     * Transforma 0 ou 1 Sim ou Não
     * @param int $value
     * @return unknown_type
     */
    private function reverseTranslateCheckboxes ($value)
    {

        $string = ($value == 0) ? 'Nao' : 'Sim';
        return $string;
    }

    /**
     * Actualiza o Job na base de dados
     * @return mixed
     */
    public function updateAction ()
    {
        $this->view->form = new App_Forms_Open();
        
        if ($this->form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $numobra = $filterValues->filter($this->_request
                ->getPost('numobra'));
            $cliente = $filterValues->filter($this->_request
                ->getPost('cliente'));
            $produto = $filterValues->filter($this->_request
                ->getPost('produto'));
            $formato = $filterValues->filter($this->_request
                ->getPost('formato'));
            $formato = App_Auxiliar_Formato::replaceAst($formato);
            $edicao = $filterValues->filter($this->_request
                ->getPost('edicao'));
            $cartolina = $filterValues->filter($this->_request
                ->getPost('cartolina'));
            $espessura = $filterValues->filter($this->_request
                ->getPost('espessura'));
            $codproduto = $filterValues->filter($this->_request
                ->getPost('codproduto'));
            $codlaetus = $filterValues->filter($this->_request
                ->getPost('codlaetus'));
            $codvisual = $filterValues->filter($this->_request
                ->getPost('codvisual'));
            $codf3 = $filterValues->filter($this->_request
                ->getPost('codf3'));
            $numcores = App_Service_Cleaners_Colors::stringClean($this->form->getValue('numcores'));
            $vernizmaq = $filterValues->filter($this->_request
                ->getPost('vernizmaq'));
            $vernizuv = $filterValues->filter($this->_request
                ->getPost('vernizuv'));
            $vernizagua = $filterValues->filter($this->_request
                ->getPost('vernizagua'));
            $plastificacao = $filterValues->filter($this->_request
                    ->getPost('plastificacao'));
            $estampagem = $filterValues->filter($this->_request
                    ->getPost('estampagem'));
            $braille = $filterValues->filter($this->_request
                ->getPost('braille'));
            $picote = $filterValues->filter($this->_request
                ->getPost('picote'));
            $relevo = $filterValues->filter($this->_request
                ->getPost('relevo'));        
            $prova = $filterValues->filter($this->_request
                ->getPost('prova'));

            $codproduto = str_replace(" ", "", $codproduto);    
               
            if ($this->checkJobNumber($numobra) == 0) {
                $this->job
                    ->insertObra($numobra, $cliente, $produto, $formato, $edicao, $cartolina, $espessura, $codproduto, $codlaetus, $codvisual, $codf3, $numcores, $this->reverseTranslateCheckboxes($vernizmaq), $this->reverseTranslateCheckboxes($vernizuv), $this->reverseTranslateCheckboxes($vernizagua), $this->reverseTranslateCheckboxes($plastificacao), $this->reverseTranslateCheckboxes($estampagem), $this->reverseTranslateCheckboxes($braille), $this->reverseTranslateCheckboxes($picote),$this->reverseTranslateCheckboxes($relevo), $prova);
            } else {
                $this->job
                    ->updateJob($numobra, $cliente, $produto, $formato, $edicao, $cartolina, $espessura, $codproduto, $codlaetus, $codvisual, $codf3, $numcores, $this->reverseTranslateCheckboxes($vernizmaq), $this->reverseTranslateCheckboxes($vernizuv), $this->reverseTranslateCheckboxes($vernizagua), $this->reverseTranslateCheckboxes($plastificacao), $this->reverseTranslateCheckboxes($estampagem), $this->reverseTranslateCheckboxes($braille), $this->reverseTranslateCheckboxes($picote), $this->reverseTranslateCheckboxes($relevo), $prova);
            }
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->form->getMessages();
            $this->view->numobra = $this->_request->getPost('numobra');
            $this->view->form = $this->form;
        }
        
    }
    
   
    
    
}