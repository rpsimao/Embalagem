<?php

/**
 * LabshomeController
 * 
 * @author
 * @version 
 */
class LabshomeController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->labs = new App_User_Service_LabsName();
        $this->form = new App_Forms_NewLab();
    }

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {

        $labsName = $this->labs
            ->getAll();
        $this->view->labs = $labsName;
    }

    public function newAction ()
    {

        $this->view->form = $this->form;
    }

    public function editAction ()
    {

        $id = $this->_getParam('id');
        $lab = $this->labs
            ->getbyID($id);
        $this->view->form = $this->form
            ->populate($lab->toArray());
    }

    public function insertAction ()
    {

        if ($this->form
            ->isValid($_POST)) {
            //
            $this->labs
                ->insert($this->form
                ->getValues());
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->form
                ->getMessages();
            $this->view->form = $this->form;
        }
    }
}

