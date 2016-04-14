<?php

class CortantesController extends Zend_Controller_Action
{


    protected $table;

    protected $form;

    protected $cortantesExecucaoForm;

    protected $modelCortantesExecucao;

    public function init ()
    {

	    $this->redirect("/diecuts");

        $this->table = new App_User_Service_Cortantes();
        $this->form = new App_Forms_Cortantes();
        $this->cortantesExecucaoForm = new App_Forms_CortantesExecucao();
        $this->modelCortantesExecucao = new App_User_Service_CortantesExecucao();
    }

    public function indexAction ()
    {

        $page = $this->_getParam('page', 1);
        //
        $paginatorAutoplatina = new App_Service_Paginator_Tables($this->table->getAllByType('autoplatina'), 15, $page);
        $this->view->autoplatina = $paginatorAutoplatina->paginate();
        //
        $paginatorCilindrica = new App_Service_Paginator_Tables($this->table->getAllByType('cilindrica'), 15, $page);
        $this->view->cilindrica = $paginatorCilindrica->paginate();
        //
        $paginatorExecucao = new App_Service_Paginator_Tables($this->modelCortantesExecucao->getAll(), 15, $page);
        $this->view->execucao = $paginatorExecucao->paginate();
        
    }

    public function displayAction ()
    {

        $id = $this->_getParam('id');
        //
        $individualPath = '/arqcortantes/' . $id . '/' . $id . 'i.pdf';
        $individualImagePath = '/arqcortantes/' . $id . '/' . $id . 'i.jpg';
        if (! file_exists($individualImagePath)) {
            $individual = new App_Files_Arqcortantes_Images_Create();
            $individual->setPath($individualPath);
            $individual->setSize(400);
            $individual->setImagePath($individualImagePath);
            $individual->convert();
        }
        //
        $planoPath = '/arqcortantes/' . $id . '/' . $id . 'p.pdf';
        $planoImagePath = '/arqcortantes/' . $id . '/' . $id . 'p.jpg';
        if (! file_exists($planoPath)) {
            $this->view->plano = False;
        }
        if (! file_exists($planoImagePath)) {
            $plano = new App_Files_Arqcortantes_Images_Create();
            $plano->setPath($planoPath);
            $plano->setSize(400);
            $plano->setImagePath($planoImagePath);
            $plano->convert();
        }
        $this->view->id = $id;
    }

    public function editAction ()
    {

        $id = $this->_getParam('id');
        $sql = $this->table
            ->getSingleArchive($id);
        $setFormAction = $this->form
            ->setAction('/cortantes/update/' . $id);
        $form = $this->form
            ->displayFormWithPopulate($sql->toArray());
        $this->view->form = $form;
    }

    public function newAction ()
    {

        $this->form
            ->setAction('/cortantes/create');
        $this->view->form = $this->form
            ->displayForm();
    }

    public function createAction ()
    {

        $form = $this->form
            ->displayForm();
        if ($form->isValid($_POST)) {
            $arrayformValues = $form->getValues();
            $this->table
                ->insert($arrayformValues);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function searchAction ()
    {
        $delimiter = $this->_getParam('delimiter');    
        
        if ($this->_getParam('id') == 0) {
            $param = $this->_getParam('query');
            $query = $this->table
                ->genericSearch('cortante', $param, $delimiter);
        }
        if ($this->_getParam('id') == 1) {
            $param = $this->_getParam('query');
            $query = $this->table
                ->genericSearch('codigo', $param, $delimiter);
        }
        if ($this->_getParam('id') == 2) {
            $param = $this->_getParam('query');
            $query = $this->table
                ->genericSearch('A', $param, $delimiter);
        }
        if ($this->_getParam('id') == 3) {
            $param = $this->_getParam('query');
            $query = $this->table
                ->genericSearch('A_B', $param, $delimiter);
        }
        if ($this->_getParam('id') == 4) {
            $param = $this->_getParam('query');
            $query = $this->table
                ->genericSearch('A_B_H', $param, $delimiter);
        }
        $this->view->results = $query;
    }

    public function updateAction ()
    {

        $id = $this->_getParam('id');
        $setForm = $this->form
            ->setAction('/cortantes/update/' . $id);
        $form = $this->form
            ->displayForm();
        if ($form->isValid($_POST)) {
            $arrayId = array(
                'id' => $id);
            $arrayformValues = $form->getValues();
            $this->table
                ->update($arrayId + $arrayformValues);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->form
                ->getMessages();
            $this->view->form = $this->form;
        }
    }

    public function deleteAction ()
    {

        //$this->_helper->viewRenderer->setNoRender();
        //$this->_helper->layout->disableLayout();
        $id = (int) $this->_getParam('id');
        $this->table->delete($id);
    }

    public function viewAction ()
    {

        $id = (int) $this->_getParam('id');
        $this->view->cortante = $this->table->getSingleArchive($id);
    }

    public function execucaoAction ()
    {

        $cortanteN = $this->modelCortantesExecucao
            ->getLastCortante();
       $form = $this->cortantesExecucaoForm
            ->populate(array(
            'cortante' => $cortanteN['cortante'] + 1));
         $this->view->form = $form;    
    }

    public function execinsertAction ()
    {

        $form = $this->cortantesExecucaoForm;
        if ($form->isValid($_POST)) {
            $arrayformValues = $form->getValues();
            $this->modelCortantesExecucao
                ->insert($arrayformValues);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function execeditAction ()
    {

        $id = (int) $this->_getParam('id');
        $sql = $this->modelCortantesExecucao->getSingleCortante($id);
        $form = $this->cortantesExecucaoForm
            ->populate($sql->toArray());
         $this->view->form = $form; 
         $this->view->formValues = $sql->toArray();
        
    }
}







