<?php

class CartolinaController extends Zend_Controller_Action
{

    public function init()
    {
        if ($this->_helper->FlashMessenger->hasMessages()) {
        $this->view->messages = $this->_helper->FlashMessenger->getMessages();
        }
        
        $this->form = new App_Forms_Cartolina();
        $this->view->form = $this->form;
    }

    public function indexAction()
    {
        $id = $this->_getParam('id');
        
        $this->form->populate(array('id'=>$id));
        
    }

    public function insertAction()
    {
        if ($this->getRequest()->isPost()){
            if ($this->form->isValid($this->_request->getPost()))
                {
                   $cartDB = new App_User_Service_Cartolina();
                   $cartDB->insert($this->form->getValues());

                   $this->_helper->flashMessenger->addMessage('Foi adicionado uma nova gramagem com sucesso.');
                   $this->redirect('/obra/' . $this->form->getValue('id'));
                   
                } else {
                     $this->view->errors = $this->form->getMessages();
                 }
        }
    }


}



