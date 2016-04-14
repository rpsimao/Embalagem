<?php
/**
 * ProvasController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class ProvasController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->optimus = new App_User_Service_Optimus();
        $this->job = new App_User_Service_Obras();
        $this->_helper->layout()->setLayout('layout-iso');
    }

    public function indexAction ()
    {

        $sql = $this->optimus->genericQueryAll('select *, count(`tm_job`) from `tm` where `tm_job` > "39000" group by `tm_job` having count(*) = 1 order by `tm_job` DESC');
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($sql);
        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($page);
        $this->view->provas = $paginator;
        $this->view->optimus = $this->optimus;
        $this->view->job = $this->job;
    }
}