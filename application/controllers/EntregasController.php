<?php
/**
 * EntregasController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class EntregasController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->optimus = new App_User_Service_Optimus();
        $this->view->obras = new App_User_Service_Obras();
        $this->_helper->layout()->setLayout('layout-iso');
    }

    public function indexAction ()
    {

        $jobsEntregues = $this->optimus->getAllFromJobTableEntregues();
        $page = $this->_getParam('page', 1);
        $paginatorJob = Zend_Paginator::factory($jobsEntregues);
        $paginatorJob->setItemCountPerPage(20);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->jobEntregues = $paginatorJob;
        $this->view->allJobsEntregues = $jobsEntregues;
        //
    }

    public function searchAction ()
    {

        $labName = $this->_getParam('lab');
        $date = $this->_getParam('date');
        $date1 = $this->_getParam('date1');
        $date2 = $this->_getParam('date2');
        if ($labName != null) {
            $query = $this->optimus->searchByLabAndDate(App_GetLabs::changeLabName($labName), $date);
            $page = $this->_getParam('page', 1);
            $paginatorJob = Zend_Paginator::factory($query);
            $paginatorJob->setItemCountPerPage(15);
            $paginatorJob->setCurrentPageNumber($page);
            $this->view->results = $paginatorJob;
        } else {
            $query = $this->optimus->searchBetweenDates($date1, $date2);
            $page = $this->_getParam('page', 1);
            $paginatorJob = Zend_Paginator::factory($query);
            $paginatorJob->setItemCountPerPage(15);
            $paginatorJob->setCurrentPageNumber($page);
            $this->view->results = $paginatorJob;
        }
    }
}

