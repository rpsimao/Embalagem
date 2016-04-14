<?php
/**
 * ClichesController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class ClichesController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->clicheDB = new App_User_Service_Cliche();
        $this->form = new App_Forms_Cliche();
    }

    public function indexAction ()
    {

        $labsName = $this->clicheDB->getAll();
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($labsName);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function newAction ()
    {

        $setForm = $this->form->setAction('/cliches/create');
        $form = $this->form->displayForm();
        $this->view->form = $form;
    }

    public function createAction ()
    {

        $setForm = $this->form->setAction('/cliches/create');
        $form = $this->form->displayForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $lab = $filterValues->filter($this->_request->getPost('laboratorio'));
            $cortante = $filterValues->filter($this->_request->getPost('cortante'));
            $this->clicheDB->insert(array(
                $lab , 
                $cortante));
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function deleteAction ()
    {

        $id = $this->_getParam('id');
        $this->clicheDB->delete($id);
    }

    public function searchAction ()
    {

        if ($this->_request->getPost('cortante') != Null) {
            $sql = $this->clicheDB->searchCort($this->_request->getPost('cortante'));
        } else {
            $sql = $this->clicheDB->getCortantes($this->_request->getPost('laboratorio'));
        }
        $this->view->sql = $sql;
    }

    public function editAction ()
    {

        $id = $this->_getParam('id');
        $sql = $this->clicheDB->getSingleArchive($id);
        $setFormAction = $this->form->setAction('/cliches/update/' . $id);
        $form = $this->form->displayFormWithPopulate(array(
            'laboratorio' => $sql['laboratorio'] , 
            'cortante' => $sql['cortante']));
        $this->view->form = $form;
    }

    public function updateAction ()
    {

        $id = $this->_getParam('id');
        $setForm = $this->form->setAction('/chapas/update/' . $id);
        $form = $this->form->displayForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $laboratorio = $filterValues->filter($this->_request->getPost('laboratorio'));
            $cortante = $filterValues->filter(strtoupper($this->_request->getPost('cortante')));
            $sql = $this->clicheDB->update(array(
                $id , 
                $laboratorio , 
                $cortante));
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }
}

