<?php

class CaixasController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->table = new App_User_Service_Cartelas();
    }

    public function preDispatch ()
    {

        $this->_helper->layout()->setLayout('3column');
        $this->view->setEscape('stripslashes');
        $this->view->records = $this->table->getAll();
    }

    public function indexAction ()
    {
        foreach ($this->view->records as $record) {
            $imagens[] = $record['codbarras'];
        }
        $this->view->sampleImage = $imagens[array_rand($imagens)];
    }

    public function cartelasAction ()
    {
    }
}



