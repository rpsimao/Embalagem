<?php

class ChapasController extends Zend_Controller_Action
{

    public function init ()
    {
		$this->redirect("/chapasrecuperadas");


	    $this->chapas = new chapasrec();
        $this->form = new App_Forms_ChapasRec();
    }

    public function indexAction ()
    {

        $result = $this->chapas->getAllRecordsByDate();
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(15);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;


	    $chRec = new App_Calculations_ChapasRecuperadas();
	    $this->view->chRecuperadas = $chRec->calculateByYear();
        
        
        $this->view->clients = $this->chapas->getClients();
        
    }

    public function newAction ()
    {

        $this->form->setAction('/chapas/create');
        $form = $this->form->displayForm();
        $this->view->form = $form;
    }

    public function createAction ()
    {

        $this->form->setAction('/chapas/create');
        $form = $this->form->displayForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $obra = $filterValues->filter($this->_request->getPost('obra'));
            $cliente = $filterValues->filter(ucfirst(strtolower($this->_request->getPost('cliente'))));
            $cores = $filterValues->filter($this->_request->getPost('cores'));
            $verniz = $filterValues->filter($this->_request->getPost('verniz'));
            $dia = $filterValues->filter($this->_request->getPost('dia'));
            $sql = $this->chapas->insertRecords($obra, $cliente, $cores, $verniz, $dia);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function editAction ()
    {

        $obra = $this->_getParam('obra');
        $sql = $this->chapas->getRecordByJobNumber($obra);
        $setForm = $this->form->setAction('/chapas/update');
        $form = $this->form->displayFormWithPopulate(array(
            'obra' => $sql->obra , 
            'cliente' => $sql->cliente , 
            'cores' => $sql->cores , 
            'verniz' => $sql->verniz , 
            'dia' => $sql->dia));
        $this->view->form = $form;
    }

    public function deleteAction ()
    {

        $obra = $this->_getParam('obra');
        $this->chapas->deleteRecord($obra);
    }

    public function updateAction ()
    {

        $setForm = $this->form->setAction('/chapas/update');
        $form = $this->form->displayForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $obra = $filterValues->filter($this->_request->getPost('obra'));
            $cliente = $filterValues->filter(ucfirst(strtolower($this->_request->getPost('cliente'))));
            $cores = $filterValues->filter($this->_request->getPost('cores'));
            $verniz = $filterValues->filter($this->_request->getPost('verniz'));
            $dia = $filterValues->filter($this->_request->getPost('dia'));
            $sql = $this->chapas->updateRecord($obra, $cliente, $cores, $verniz, $dia);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }
    
    public function searchAction()
    {
        
        $obra = $this->_request->getPost('obra');
        $sql = $this->chapas->getRecordByJobNumber($obra);
        
        $this->view->sql = $sql;
        
    }
    
    
    public function clientsAction() 
    {
        
    }
    
    
}

