<?php

class ChapasrecuperadasController extends Zend_Controller_Action
{

    public function init ()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');

        $this->chapas = new chapasrec();



    }


	public function preDispatch()
	{
		if ($this->_helper->FlashMessenger->hasMessages()) {
			$this->view->messages = $this->_helper->FlashMessenger->getMessages();
		}


	}

    public function indexAction ()
    {



	    $a = new App_Calculations_ChapasRecuperadas();
	    $this->view->chapasRec = $a->calculateByYear();


	    $form = new App_Forms_NewChapasRecuperadas();
	    $this->view->form = $form;

	    $this->view->clients = $this->chapas->getClients();


        
    }

    public function newAction ()
    {
	    $form = new App_Forms_ChapasRecNew();
	    $form->setAction('/chapasrecuperadas/create');
        $this->view->form = $form;
    }

    public function createAction ()
    {

	    $form = new App_Forms_ChapasRecNew();
	    $form->setAction('/chapasrecuperadas/create');
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $obra    = $filterValues->filter($this->_request->getPost('obra'));
            $cliente = $filterValues->filter(ucfirst(strtolower($this->_request->getPost('cliente'))));
            $cores   = $filterValues->filter($this->_request->getPost('cores'));
            $verniz  = $filterValues->filter($this->_request->getPost('verniz'));
            $dia     = $filterValues->filter($this->_request->getPost('dia'));
            $this->chapas->insertRecords($obra, $cliente, $cores, $verniz, $dia);

	        $this->_helper->flashMessenger->addMessage("O Registo foi introduzido com sucesso.");
	        $this->redirect("/chapasrecuperadas");

        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }




	public function addclientesAction()
	{


		$this->_helper->layout->disableLayout();


		$chapas = new chapasrec();
		$this->view->clientes = $chapas->getClients();



		/*$setLabs = array();
		$setLabs[""] = "Escolha o cliente";

		foreach ($cliArray as $value) {

			$setLabs[$value['cliente']] = $value['cliente'];
		}

		return $setLabs;*/





	}


	public function editAction ()
    {

        $obra = $this->_getParam('obra');
        $sql = $this->chapas->getRecordByJobNumber($obra);
        $form = new App_Forms_ChapasRecNew();
	    $form->setAction('/chapasrecuperadas/update');
	    $form->populate(array(
		    'obra' => $sql->obra ,
		    'cliente' => $sql->cliente ,
		    'cores' => $sql->cores ,
		    'verniz' => $sql->verniz ,
		    'dia' => $sql->dia));
	    $this->view->form = $form;


    }

    public function deleteAction ()
    {

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
	    $obra = $this->_getParam('obra');
        $this->chapas->deleteRecord($obra);
    }

    public function updateAction ()
    {

	    $form = new App_Forms_ChapasRecNew();
	    $form->setAction('/chapasrecuperadas/update');
        if ($form->isValid($_POST)) {

	        $filterValues = new Zend_Filter_StripTags();
            $obra = $filterValues->filter($this->_request->getPost('obra'));
            $cliente = $filterValues->filter(ucfirst(strtolower($this->_request->getPost('cliente'))));
            $cores = $filterValues->filter($this->_request->getPost('cores'));
            $verniz = $filterValues->filter($this->_request->getPost('verniz'));
            $dia = $filterValues->filter($this->_request->getPost('dia'));
            $this->chapas->updateRecord($obra, $cliente, $cores, $verniz, $dia);

	         $this->_helper->flashMessenger->addMessage("O Registo foi introduzido com sucesso.");
	        $this->redirect("/chapasrecuperadas");
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }
    
    public function searchAction()
    {
        
        $this->_helper->layout->disableLayout();


	    $obra = $this->_request->getPost('obra');
        $sql = $this->chapas->getRecordByJobNumber($obra);
        
        $this->view->sql = $sql;

    }
    
    
    public function clientsAction() 
    {
        
    }
    
    
}

