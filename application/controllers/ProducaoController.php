<?php

/**
 * EntregasController
 *
 * @author
 * @version 
 *
 */
/**
 * EntregasController
 *
 * @author
 *
 *
 * @version
 *
 *
 *
 */
class ProducaoController extends Zend_Controller_Action
{

    public $optimus;


    public function init ()
    {

        $this->optimus = new App_User_Service_Optimus();
        $this->view->obras = new App_User_Service_Obras();
        //$this->_helper->layout()->setLayout('layoutisoautorefresh');

        $this->_helper->layout()->setLayout('layout-iso-bootstrap');
        $this->obras = new App_User_Service_Obras();
    }

    public function indexAction ()
    {

        $jobsProducao = $this->optimus->getAllFromJobTableProducao();
        $page = $this->_getParam('page', 1);
        $paginatorJob = Zend_Paginator::factory($jobsProducao);
        $paginatorJob->setItemCountPerPage(15);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->jobProducao = $paginatorJob;
        $this->view->allJobsProducao = $jobsProducao;
        //
        $todayJobs = $this->optimus->getJobNumberToDeliveryToday();
        $this->view->today = $todayJobs;
        //
        $tomorrowJobs = $this->optimus->getAllFromJobTableProducaoTomorrow();
        $this->view->tomorrow = $tomorrowJobs;

        $this->render("new");
    }

    public function todayAction ()
    {

        $jobsProducao = $this->optimus->getJobNumberToDeliveryToday();
        $page = $this->_getParam('page', 1);
        $paginatorJob = Zend_Paginator::factory($jobsProducao);
        $paginatorJob->setItemCountPerPage(15);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->jobProducaoToday = $paginatorJob;
    }

    public function tomorrowAction ()
    {

        $jobsProducao = $this->optimus->getAllFromJobTableProducaoTomorrow();
        $page = $this->_getParam('page', 1);
        $paginatorJob = Zend_Paginator::factory($jobsProducao);
        $paginatorJob->setItemCountPerPage(15);
        $paginatorJob->setCurrentPageNumber($page);
        $this->view->jobProducaoTomorrow = $paginatorJob;
    }

    public function searchAction ()
    {

        $labName = $this->_getParam('lab');
        $date = $this->_getParam('date');
        $date1 = $this->_getParam('date1');
        $date2 = $this->_getParam('date2');
        if ($labName != null) {
            $query = $this->optimus->getAllFromJobTableByLab(App_GetLabs::changeLabName($labName));
            $page = $this->_getParam('page', 1);
            $paginatorJob = Zend_Paginator::factory($query);
            $paginatorJob->setItemCountPerPage(15);
            $paginatorJob->setCurrentPageNumber($page);
            $this->view->results = $paginatorJob;
        } else 
            if ($date != null) {
                $query = $this->optimus->getAllFromJobTableByDate($date);
                $page = $this->_getParam('page', 1);
                $paginatorJob = Zend_Paginator::factory($query);
                $paginatorJob->setItemCountPerPage(15);
                $paginatorJob->setCurrentPageNumber($page);
                $this->view->results = $paginatorJob;
            } else 
                if ($date1 != null) {
                    $query = $this->optimus->searchBetweenDates($date1, $date2);
                    $page = $this->_getParam('page', 1);
                    $paginatorJob = Zend_Paginator::factory($query);
                    $paginatorJob->setItemCountPerPage(15);
                    $paginatorJob->setCurrentPageNumber($page);
                    $this->view->results = $paginatorJob;
                }
    }

    public function trelloAction ()
    {
        $jobsProducao = $this->optimus->getAllFromJobTableProducao();
        
        
        $todayPHP = date('Y-m-d');
        foreach ($jobsProducao as $value) {
            $cc = App_JobState::getCleanState($value['j_number']);
            $dbEmbalagem = $this->obras->getValues($value['j_number']);
            $producao = $this->optimus->getAllStagesOfJob($value['j_number']);
            /**
             * Data
             */
            if (date('l') == "Friday") {
                $today = new Zend_Date();
                $dayT = $today->add('3', Zend_Date::DAY);
                $tomorrow = date('Y') . '-' . App_Auxiliar_ChangeMonth::changeMonth($dayT) . '-' . $dayT;
            } else {
                $today = new Zend_Date();
                $dayT = $today->add('1', Zend_Date::DAY);
                $tomorrow = date('Y') . '-' . App_Auxiliar_ChangeMonth::changeMonth($dayT) . '-' . $dayT;
            }
            if ($value['j_deldate'] == $todayPHP) {
                $rowColor = 'orange';
            } else 
                if ($value['j_deldate'] == $tomorrow) {
                    $rowColor = 'green';
                } else 
                    if ($value['j_deldate'] < $todayPHP) {
                        $rowColor = 'red';
                    } else {
                        $rowColor = 'green';
                    }
            /**
             * Fim Data
             */
                    

            $values = array('job'        => $value['j_number'] , 
                    		'cliente'    => $value['j_customer'] , 
                            'trabalho'   => $value['j_title1'] ,
                            'formato'    => $dbEmbalagem['formato'],
                            'cartolina'  => $dbEmbalagem['cartolina'],
                            'edicao'     => $dbEmbalagem['edicao'],
                        	'codproduto' => $dbEmbalagem['codproduto'],
                			'codf3'      => $dbEmbalagem['codf3'],
                			'datapedida' => $value['j_deldate'],
                			'qtdpedida'  => $value['j_qty_ordered'],
                 			'status'     => $rowColor);      
                    
                    
            if ($cc == "Prepress") { $pp[] = $values;}
            if ($cc == "Impressão") {$imp[] = $values;}
            if ($cc == "Acabamentos") {$acab[] = $values;}
        }
        $this->view->prepress = $pp;
        $this->view->impressao = $imp;
        $this->view->acabamentos = $acab;
    }
}


