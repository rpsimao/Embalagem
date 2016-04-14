<?php

/**
 *Controller para inserir o número de obra para inicializar um Job
 *
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class SeloController extends Zend_Controller_Action
{

    public function indexAction ()
    {

        
        $this->view->form = new App_Forms_Open();
    }
}

