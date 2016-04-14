<?php

class ArqbrailleController extends Zend_Controller_Action
{

    public function init()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');

	    $this->table     = new Arqbrailles();
        $this->form      = new App_Forms_ArqBrailles();
        $this->view->nav = new App_View_Helper_ArqBraillesSearchNav();

    }

    public function preDispatch()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
            $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        } 
    }

    public function indexAction()
    {
        $this->redirect("/arqbraille/listagem");
    }


	public function listagemAction(){

		$page = $this->_getParam('page', 1);
		$db = new Arqbrailles();

		$paginator = new App_Service_Paginator_Tables($db->getAll(), 15, $page);
		$this->view->records = $paginator->paginate();

	}


	public function pricesimulationAction(){

		$this->view->form = new App_Forms_ArqBraillesPriceSimulation();
		$this->view->formfemea = new App_Forms_BrailleFemeaSimulation();

	}


	public function editAction()
    {
        $id = $this->_getParam('id');
        $db = $this->table->findById($id);
        
        $this->view->form = $this->form->populate($db);
	    $this->view->num = $db["nbraille_num"];
        

	   $this->view->formRep = new App_Forms_ArqBraillesRep();
        
    }

    public function createAction()
    {
        if ($this->getRequest()->isPost()) {
            if ($this->form->isValid($_POST)) {
                $params = $this->form->getValues();
                $this->table->insertData($params);
                $this->view->messageTxt ='O braille para o registo <strong>' . str_replace(",", ", ", $params['obras']) . "</strong> foi criado com sucesso.";
                /*$this->_redirect("/arqbraille/");*/
                $this->view->brailleNum = $this->form->getValue('nbraille_num');
            } else {
                $this->view->errors = $this->form->getMessages();
                $this->view->form = $this->form;
            }
        } 
        
    }

    public function deleteAction(){}

    public function newAction()
    {

	    $this->view->form = $this->form;
    }

    public function ajaxAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        $jnumber = $this->_getParam('j_number');
        
        $optimus = new App_User_Service_Optimus();
        $obras = new App_User_Service_Obras();
        $obrasData = $obras->getValues($jnumber);
        $data = $optimus->checkObra($jnumber);
        $last = $this->table->getLastNumber()->toArray();
        $last = $last[0]['nbraille_num'] + 1;
        
        $dbArq = new ArqbraillesLabsTable();
        $dbArqRes = $dbArq->searchCustomer($data[0]['j_customer']);
        
       
        
        if ($dbArqRes != false) {
            
            $cliente = $dbArqRes;
        
        } else {
            
            $cliente = substr($data[0]['j_customer'], 0 , 3);
        }

        try {
            
            $vals = array('cliente' => $cliente,
                          'mes' => date('m'),
                          'ano' => date('y'),
                          'produto' => $data[0]['j_title1'],
                          'codcli' => $data[0]['j_title2'],
                          'last' => $last,
                          'codf3' => $obrasData['codf3']

            );
        } catch (Exception $e) {
            
            $vals = array('error' => 'error');
        }
        
        $json = Zend_Json_Encoder::encode($vals);
        
        $this->getResponse()->appendBody($json);
        
        
    }

    public function searchobraAction()
    {
       
       $db = new Arqbrailles();
       $this->view->records = $db->getByJob($this->_request->getPost('job'));
	   $this->view->postvalue =  $this->_request->getPost('job');


    }

    public function searchbrailleAction()
    {
        
       $db = new Arqbrailles();
       $this->view->records = $db->getByBraille($this->_request->getPost('braille'));
	   $this->view->counter =  $this->view->records;
	   $this->view->postvalue =  $this->_request->getPost('braille');
	   $this->_helper->viewRenderer->setRender('searchobra');
    }

    public function searchtxtAction()
    {
	   $page = $this->_getParam('page', 1);
	   $db = new App_User_Service_Braille();
	   $session = new Zend_Session_Namespace('arqbrailles_txt_session_manager_namespace');

	    if ($this->getRequest()->isPost()) {

		    $paginator = new App_Service_Paginator_Tables($db->searchTxt($this->_request->getPost('txt')), 10, $page);
		    $session->data = $this->_request->getPost('txt');


	    } else {

		    $paginator = new App_Service_Paginator_Tables($db->searchTxt($session->data), 10, $page);

	    }

	   $this->view->records = $paginator->paginate();
	   $this->view->postvalue =  $session->data;

    }

    public function searchlabAction()
    {
	    $page = $this->_getParam('page', 1);
	    $db = new Arqbrailles();
	    $session = new Zend_Session_Namespace('arqbrailles_labs_session_manager_namespace');

	    if ($this->getRequest()->isPost()) {

		    $paginator = new App_Service_Paginator_Tables($db->getByLabs($this->_request->getPost('labs')), 10, $page);
		    $session->data = $this->_request->getPost('labs');

	    } else {

		    $paginator = new App_Service_Paginator_Tables($db->getByLabs($session->data), 10, $page);

	    }

	    $this->view->records = $paginator->paginate();
	    $this->view->postvalue =  $session->data;


	    $this->_helper->viewRenderer->setRender('searchobra');
    }

    public function searchcodigoclienteAction()
    {
        $db = new Arqbrailles();

	    $this->view->records = $db->getByCodCli($this->_request->getPost('codcli'));
	    $this->view->postvalue =  $this->_request->getPost('codcli');

	    $this->_helper->viewRenderer->setRender('searchobra');

    }

    public function searchcodif3Action()
    {
       $db = new Arqbrailles();
       $this->view->records = $db->getByCodF3($this->_request->getPost('codf3'));
	    $this->view->postvalue =  $this->_request->getPost('codf3');
	   $this->_helper->viewRenderer->setRender('searchobra');

    }

    public function editobraAction()
    {
        $id = $this->_getParam('obra');
        $db = $this->table->getOneJob($id);
        
        //$this->view->form = $this->form->populate($db[0]);*/
        
       
    }

    public function createlabAction()
    {
        $form = new App_Forms_ArqBraillesLabs();
        if ($this->getRequest()->isPost()) {
            if ($form->isValid($_POST)) {
                $params = $form->getValues();
                $db = new ArqbraillesLabsTable();
                $db->insertData($params);
                
                $this->_helper->flashMessenger->addMessage('O Laboratório ' . $params['shortname'] . " foi criado com sucesso.");
                $this->redirect("/arqbraille/");
                
                
            } else {
                $this->view->errors = $form->getMessages();
                $this->view->form = $form;
            }
        } 
    }

    public function labsAction()
    {
        $this->view->form = new App_Forms_ArqBraillesLabs();

	    $db = new ArqbraillesLabsTable();

	    $this->view->labs = $db->listLabs();

    }

    public function seloAction()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
              
        if ($ip == "193.3.3.36") {
            $form = new App_Forms_BrailleSelo();
            $this->view->form = $form->populate(array('verify' => 'Rosa Freitas'));
        } else {
            $this->view->form = new App_Forms_BrailleSelo();
        }
        
        
    }

    public function renderpdfAction()
    {
        if ($this->getRequest()->isPost())
        {
            $form = new App_Forms_BrailleSelo();
          if ($form->isValid($_POST)) {
            
            $this->_helper->layout->disableLayout();
            $dbArq = new ArqbraillesLabsTable();
            
            $id = $this->_request->getPost('numbraille');
            $txt = $this->_request->getPost('txtbraille');
            $verify = $this->_request->getPost('verify');
            $obs = $this->_request->getPost('obs');
            
            $db = new Arqbrailles();
            $db->insertData(array('nbraille_num' => $id, 'txtbraille' => $txt, 'obs'=>$obs));
            $records = $db->findById($id);
            
            $db2 = new ArqBraillesRep();
            
           
            
            $pdf = new App_PDF_SeloBraille();
            $pdf->setRep($db2->findPecas($id));
            $pdf->nbraille_lab      = $dbArq->reverseClient($records['nbraille_lab']);
            $pdf->nbraille_shortlab = $records['nbraille_lab'];
            $pdf->nbraille_num = $records['nbraille_num'];
            $pdf->nbraille_mes = $records['nbraille_mes'];
            $pdf->nbraille_ano = $records['nbraille_ano'];
            $pdf->codf3        = $records['codf3'];
            $pdf->codcli       = $records['codcli'];
            $pdf->produto      = $records['produto'];
            $pdf->b1           = $records['b1'];
            $pdf->b2           = $records['b2'];
            $pdf->b3           = $records['b3'];
            $pdf->b4           = $records['b4'];
            $pdf->obras        = $records['obras'];
            $pdf->oc           = $records['oc'];
            $pdf->obs          = $records['obs'];
            $pdf->txt          = $records['txtbraille'];
            $pdf->qtd          = $records['qtd'];
            $pdf->txtbraille   = $txt;
            $pdf->verify       = $verify;
            // $pdf->file         = $output;
           // $pdf->width        = $width;
           // $pdf->height       = $height;
            
            $render = $pdf->buildPDF();
            
            $this->view->pdf = $render;
          
          }  else {
                $this->view->errors = $form->getMessages();
                $this->view->form = $form;
            }
        
        } else {
                $this->_helper->layout->disableLayout();
            
               $id = $this->_getParam('id');
               $verify = $this->_getParam('nome');
                $db = new Arqbrailles();
                $records = $db->findById($id);
            
                
                $dbArq = new ArqbraillesLabsTable();
                $db2 = new ArqBraillesRep();
            
                
            
                $pdf = new App_PDF_SeloBraille();
                 $pdf->setRep($db2->findPecas($id));
                $pdf->nbraille_lab      = $dbArq->reverseClient($records['nbraille_lab']);
                $pdf->nbraille_shortlab = $records['nbraille_lab'];
                $pdf->nbraille_num = $records['nbraille_num'];
                $pdf->nbraille_mes = $records['nbraille_mes'];
                $pdf->nbraille_ano = $records['nbraille_ano'];
                $pdf->codf3        = $records['codf3'];
                $pdf->codcli       = $records['codcli'];
                $pdf->produto      = $records['produto'];
                $pdf->b1           = $records['b1'];
                $pdf->b2           = $records['b2'];
                $pdf->b3           = $records['b3'];
                $pdf->b4           = $records['b4'];
                $pdf->obras        = $records['obras'];
                $pdf->oc           = $records['oc'];
                $pdf->obs          = $records['obs'];
                $pdf->txtbraille   = $records['txtbraille'];
                $pdf->qtd          = $records['qtd'];
                $pdf->verify       = $verify;
                // $pdf->file         = $output;
                // $pdf->width        = $width;
                // $pdf->height       = $height;
            
                $render = $pdf->buildPDF();
            
                $this->view->pdf = $render;

            
        }
           }

    

    public function repAction()
    {
        //$this->_helper->layout()->disableLayout();

	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
        
        
    }

    public function repinsertAction()
    {
       
        $this->_helper->layout()->disableLayout();
        $this->view->form = new App_Forms_ArqBraillesRep();
    }

    public function repcreateAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        $db = new ArqBraillesRep();
        $db->create(array(
            'braille_num' => $this->_request->getPost('nbraille_num_rep'),
            'pecas'       => $this->_request->getPost('pecas_rep'),
            'oxidacao'    => $ox = ($this->_request->getPost('oxidacao_rep')  == null ? 0 : $this->_request->getPost('oxidacao_rep')),
            'partidos'    => $pt = ($this->_request->getPost('partidos_rep')  == null ? 0 : $this->_request->getPost('partidos_rep')),
            'esmagados'   => $es = ($this->_request->getPost('esmagados_rep') == null ? 0 : $this->_request->getPost('esmagados_rep')),
            'novo'        => $nv = ($this->_request->getPost('novo_rep')      == null ? 0 : $this->_request->getPost('novo_rep')),
        
        ));
        
        $values = array('braille_num' => $this->_request->getPost('nbraille_num_rep'),
                        'pecas'       => $this->_request->getPost('pecas_rep'));
        
        $result = Zend_Json_Encoder::encode($values);
        
        $this->getResponse()->appendBody($result);
    }

    public function replistAction()
    {
       $this->_helper->layout()->disableLayout();
       $id = $this->_getParam('id');
       
       $db = new ArqBraillesRep();
       $this->view->pecas = $db->findPecas($id);
    }
    
    public function thumbAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam('id');
        
        //$url = 'http://static.fterceiro.pt/media/scope/imagens_ricardo/'.$id.'.jpg"';
        
        $url = @getimagesize(
                "http://imagens.fterceiro.pt/media/scope/imagens_ricardo/" .
                         $id . ".jpg");
        
        if (is_array($url)) {
            $this->getResponse()->appendBody(
                    '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/' .$id . '.jpg" />');
        } else {
            
            $this->getResponse()->appendBody(
                    '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/thumb.jpg" />');
        }
        
        
    }
    
    
    public function thumbtxtAction()
    {
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
        
        $numObra = $this->_getParam('id');
        
        $optimus = new App_User_Service_Optimus();
        $optTxt = $optimus->getJobInfo2($numObra);
        
        
        $ccc = preg_match("/FT_[0-9]+/", $optTxt['sect_text'], $match);
        
        if (strlen($match[0]) > 8)
        {
            $NumericVal = preg_replace("/[^0-9]+/", "", $match[0]);
             $NumericVal = substr($NumericVal, 0, -2);
        } else {
            $NumericVal = substr($NumericVal, 3);
            
        }
        
        
        //$this->getResponse()->appendBody($NumericVal);
        
        
        
        $url = @getimagesize(
                "http://imagens.fterceiro.pt/media/scope/imagens_ricardo/" .
                $NumericVal . ".jpg");
        
        if (is_array($url)) {
            $this->getResponse()->appendBody(
                    '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/' .$NumericVal . '.jpg" id="'.$NumericVal.'"/>');
        } else {
        
            $this->getResponse()->appendBody(
                    '<img src="http://imagens.fterceiro.pt/media/scope/imagens_ricardo/thumb.jpg" id="'.$NumericVal.'" />');
        }
        
        
    }
    
    
    
    public function obrainfoAction()
    {
        
        $this->_helper->layout()->disableLayout(); 
        //$this->_helper->viewRenderer->setNoRender(true);
        
        $numObra = $this->_getParam('id');
        
        $obras = new App_User_Service_Obras();
        $optimus = new App_User_Service_Optimus();
        $this->view->job = $optimus->getJob($numObra);
        $this->view->del = $optimus->getDeliveries($numObra);
        $this->view->obraInfo = $obras->getValues($numObra);
        
    }


}








































