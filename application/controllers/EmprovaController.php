<?php
/**
 * EmprovaController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class EmprovaController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->model = new EmprovaTable();
        $this->form = new App_Forms_Emprova();
        $this->optimus = new App_User_Service_Optimus();
        $this->view->obras = new App_User_Service_Obras();
        $this->view->optimus = new App_User_Service_Optimus();
    }

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {

        $this->_helper->layout()->setLayout('layout-iso');
        $emProva = $this->model->getAllRecords();
        $page = $this->_getParam('page', 1);
        //
        $paginatorJob = Zend_Paginator::factory($emProva);
        $paginatorJob->setItemCountPerPage(15);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->emprova = $paginatorJob;
        //
        $paginatorJob = Zend_Paginator::factory($this->optimus->getJobsInProvas());
        $paginatorJob->setItemCountPerPage(15);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->emprovaOptimus = $paginatorJob;
    }

    public function newAction ()
    {

        $this->view->form = $this->form;
    }

    public function createAction ()
    {

        if ($this->form->isValid($this->_request->getPost())) {
            $this->model->insertFormValues($this->form->getValues());
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->form->getMessages();
            $this->view->form = $this->form;
        }
    }

    public function searchAction ()
    {

        $labName = $this->_getParam('lab');
        $date = $this->_getParam('date');
        $date1 = $this->_getParam('date1');
        $date2 = $this->_getParam('date2');
        $obra = $this->_getParam('obra');
        if ($labName != null) {
            $query = $this->model->getAllRecordsByLab(App_GetLabs::changeLabName($labName));
            $page = $this->_getParam('page', 1);
            $paginatorJob = Zend_Paginator::factory($query);
            $paginatorJob->setItemCountPerPage(15);
            $paginatorJob->setCurrentPageNumber($page);
            $this->view->results = $paginatorJob;
        } else 
            if ($date != null) {
                $query = $this->model->getAllByDate($date);
                $page = $this->_getParam('page', 1);
                $paginatorJob = Zend_Paginator::factory($query);
                $paginatorJob->setItemCountPerPage(15);
                $paginatorJob->setCurrentPageNumber($page);
                $this->view->results = $paginatorJob;
            } else 
                if ($date1 != null) {
                    $query = $this->model->searchBetweenDates($date1, $date2);
                    $page = $this->_getParam('page', 1);
                    $paginatorJob = Zend_Paginator::factory($query);
                    $paginatorJob->setItemCountPerPage(15);
                    $paginatorJob->setCurrentPageNumber($page);
                    $this->view->results = $paginatorJob;
                } else 
                    if ($obra != null) {
                        $query = $this->model->getAllByJobNumber($obra);
                        $page = $this->_getParam('page', 1);
                        $paginatorJob = Zend_Paginator::factory($query);
                        $paginatorJob->setItemCountPerPage(15);
                        $paginatorJob->setCurrentPageNumber($page);
                        $this->view->results = $paginatorJob;
                    }
    }
}

