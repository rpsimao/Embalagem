<?php

class LaetusController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->model          = new App_User_Service_Laetus();
        $this->form           = new App_Forms_Laetus();
        $this->singleform     = new App_Forms_SingleLaetus();
        $this->miniform       = new App_Forms_MiniLaetus();
        $this->microform      = new App_Forms_MicroLaetus();
        $this->editlaetusform = new App_Forms_EditLaetus();
        $this->listlaetus     = new App_Forms_SearchLaetus();
    }

    public function indexAction ()
    {

        $this->view->form = $this->form;
    }

    public function createAction ()
    {

        if ($this->form->isValid($this->_request->getPost())) {
            $this->model->insert($this->form->getValues());
            if ($this->form->getValue('pdf') == 1) {
                $this->_helper->layout->disableLayout();
                $pdf = new App_PDF_Laetus();
                $pdf->setLaetusNumber($this->model->getLastLaetusCodeFromCortanteNumberForPDFCreation($this->form->getValue('cortante')));
                $pdf->setFormValues($this->form->getValues());
                $this->view->pdf = $pdf->drawBars();
                $this->view->flag = 1;
            }
        } else {
            // passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->form->getMessages();
            $this->view->form = $this->form;
        }
    }

    public function regenerateAction ()
    {

        if ($this->miniform->isValid($this->_request->getPost())) {
            $exists = $this->model->checkIfValueExists($this->miniform->getValue('cortante'));
            if (count($exists) > 0) {
                $this->_helper->layout->disableLayout();
                $pdf = new App_PDF_Laetus();
                $pdf->setLaetusNumber($this->model->getLastLaetusCodeFromCortanteNumberForPDFCreation($this->miniform->getValue('cortante')));
                $pdf->setFormValues($this->model->getValue($this->miniform->getValue('cortante')));
                $this->view->pdf = $pdf->drawBars();
            } else {
                $this->view->check = 1;
            }
        } else {
            // passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->miniform->getMessages();
            $this->view->form = $this->miniform;
        }
    }

    public function recreatelaetusAction ()
    {

        $this->view->form = $this->miniform;
    }

    public function checklaetusAction ()
    {

        $this->view->form = $this->microform;

	    $session = new Zend_Session_Namespace('temfilename');
	    //var_dump($session->array);
    }

    public function checkAction ()
    {

        if ($this->microform->isValid($this->_request->getPost())) {
            $this->_helper->layout->disableLayout();
            $pdf = new App_PDF_Laetus();
            $pdf->setLaetusNumber($this->microform->getValue('numero'));
            $this->view->pdf = $pdf->checklaetusRender();
        } else {
            // passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->microform->getMessages();
            $this->view->form = $this->microform;
        }
    }

    public function editlaetusformAction ()
    {

        $this->view->form = $this->editlaetusform;
    }

    public function editlaetusAction ()
    {

        if ($this->editlaetusform->isValid($this->_request->getPost())) {
            $this->_redirect('/laetus/list/' . $this->editlaetusform->getValue('numero'));
        } else {
            // passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->editlaetusform->getMessages();
            $this->view->form = $this->editlaetusform;
        }
    }

    public function listAction ()
    {

        $this->view->laetus = $this->model->getAllValuesByCortanteNumber($this->_getParam('cortante'));
        $this->view->cortante = $this->_getParam('cortante');
    }

    public function deleteAction ()
    {

        $id = $this->_getParam('id');
        $this->model->delete($id);
    }

    public function editlaetussingleitemAction ()
    {

        $params = $this->model->getSingleArchive($this->_getParam('id'));
        $form = $this->singleform->populate($params);
        $this->view->form = $form;
    }

    public function updateAction ()
    {

        if ($this->singleform->isValid($this->_request->getPost())) {
            $this->model->update($this->singleform->getValues());
        } else {
            // passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $this->singleform->getMessages();
            $this->view->form = $this->singleform;
        }
    }

    public function searchAction ()
    {

        $this->view->form = $this->listlaetus;
    }
}




