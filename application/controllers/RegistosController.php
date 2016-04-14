<?php

class RegistosController extends Zend_Controller_Action
{

    const INI_FILE = '../application/configs/application.ini';

    public function init ()
    {

        $this->jobs = new App_User_Service_Jobsdef();
        $this->jobsversion = new App_User_Service_Jobsdefversion();
        $this->config = new Zend_Config_Ini(self::INI_FILE, 'labs');
    }

    public function indexAction ()
    {

        $form = App_Forms_NomeLabs::getForm();
        $this->view->form = $form;
    }

    private function cleanData ($data)
    {

        $clean = ($data == "0000-00-00") ? "" : $data;
        return $clean;
    }

    public function editAction ()
    {

        $id = $this->_getParam('id');
        $values = $this->jobsversion->getValuesByID($id);
        $params = array(
            'codinterno' => $values['codinterno'] , 
            'codcliente' => $values['codcliente'] , 
            'numversao' => $values['numversao'] , 
            'numedicao' => $values['numedicao'] , 
            'data' => $this->cleanData($values['data']) , 
            'obra' => $values['registo']);
        $jobsdefversionForm = App_Forms_AdicionarRegisto::getForm();
        $jobsForm = new Zend_Form();
        $jobsForm->setAction('/registos/update/' . $values['id'] . '')->addAttribs(array(
            'id' => 'insertform'))->setMethod('post')->addElements($jobsdefversionForm)->populate($params);
        $this->view->jobsForm = $jobsForm;
    }

    public function listAction ()
    {

        $form = App_Forms_NomeLabs::getForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $numlab = $filterValues->filter($this->_request->getPost('labs'));
            $_SESSION['lab'] = $numlab;
            $config = new App_ConfigWriter(self::INI_FILE);
            $configWriter = $config->setConfig();
            $configWriter->labs->number = $numlab;
            $config->write($configWriter);
            
        }
        
        
        $sql = new App_User_Service_Jobsdef();
        if (! empty($_SESSION['lab'])) {
            $result = $sql->getAll($_SESSION['lab']);
        } else {
            $result = $sql->getAll($this->config->number);
        }
        @$this->view->lab = $_SESSION['lab'];
        $this->view->lab1 = $this->config->number;
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
        //get lab name to pass to the view
       /* $lab = new App_User_Service_LabsName();
        $labName = $lab->getLabName($this->config->number);*/
       // $this->view->lab = $this->config->number;
    }

    public function addAction ()
    {

        $params = array(
            'codinterno' => $this->_getParam('id') , 
            'data' => date('Y-m-d'));
        $jobsdefversionForm = App_Forms_AdicionarRegisto::getForm();
        $jobsForm = new Zend_Form();
        $jobsForm->setAction('/registos/insert')->addAttribs(array(
            'id' => 'insertform'))->setMethod('post')->addElements($jobsdefversionForm)->populate($params);
        $this->view->jobsForm = $jobsForm;
    }

    public function newAction ()
    {

        $formElements = App_Forms_NewCode::getForm();
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/insertrecord')->addElements($formElements)->setAttrib('id', 'newcode')->setDecorators(array(
        'FormElements',
        array('HtmlTag', array('tag' => 'table')),
        'Form'
        ));
        $this->view->form = $form;
    }

    public function newcodeAction ()
    {

        $form = App_Forms_NewCode::getForm();
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $codinterno = $filterValues->filter($this->_request->getPost('codinterno'));
            $codcliente = $filterValues->filter($this->_request->getPost('codcliente'));
            $produto = $filterValues->filter($this->_request->getPost('produto'));
            $arq = $filterValues->filter($this->_request->getPost('arq'));
            $numversao = $filterValues->filter($this->_request->getPost('numversao'));
            $numedicao = $filterValues->filter($this->_request->getPost('numedicao'));
            $data = $filterValues->filter($this->_request->getPost('data'));
            $numcortante = $filterValues->filter($this->_request->getPost('numcortante'));
            $numobra = $filterValues->filter($this->_request->getPost('numobra'));
            $jobdef = new App_User_Service_Jobsdef();
            $jobdef->insert($codinterno, $codcliente, $numversao, $numedicao, $produto, $numcortante);
            $jobdefversion = new App_User_Service_Jobsdefversion();
            $jobdefversion->insert($codinterno, $codcliente, $numversao, $numedicao, $data, $numobra);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function updateAction ()
    {

        $id = $this->_getParam('id');
        $jobsdefversionForm = App_Forms_AdicionarRegisto::getForm();
        $jobsForm = new Zend_Form();
        $jobsForm->setAction('/registos/update/' . $id . '')->addAttribs(array(
            'id' => 'insertform'))->setMethod('post')->addElements($jobsdefversionForm);
        if ($jobsForm->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $codinterno = $filterValues->filter($this->_request->getPost('codinterno'));
            $codcliente = $filterValues->filter($this->_request->getPost('codcliente'));
            $numversao = $filterValues->filter($this->_request->getPost('numversao'));
            $numedicao = $filterValues->filter($this->_request->getPost('numedicao'));
            $data = $filterValues->filter($this->_request->getPost('data'));
            $numobra = $filterValues->filter($this->_request->getPost('numobra'));
            $jobdefversion = new App_User_Service_Jobsdefversion();
            $jobdefversion->update($id, $codinterno, $codcliente, $numversao, $numedicao, $data, $numobra);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $jobsForm->getMessages();
            $this->view->form = $jobsForm;
        }
    }

    public function insertAction ()
    {

        $jobsdefversionForm = App_Forms_AdicionarRegisto::getForm();
        $jobsForm = new Zend_Form();
        $jobsForm->setAction('/registos/insert')->addAttribs(array(
            'id' => 'insertform'))->setMethod('post')->addElements($jobsdefversionForm);
        if ($jobsForm->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $codinterno = $filterValues->filter($this->_request->getPost('codinterno'));
            $codcliente = $filterValues->filter($this->_request->getPost('codcliente'));
            $numversao = $filterValues->filter($this->_request->getPost('numversao'));
            $numedicao = $filterValues->filter($this->_request->getPost('numedicao'));
            $data = $filterValues->filter($this->_request->getPost('data'));
            $numobra = $filterValues->filter($this->_request->getPost('numobra'));
            $jobdefversion = new App_User_Service_Jobsdefversion();
            $jobdefversion->insert($codinterno, $codcliente, $numversao, $numedicao, $data, $numobra);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $jobsForm->getMessages();
            $this->view->form = $jobsForm;
        }
    }

    public function deleterecordAction ()
    {

        $id = $this->_getParam('id');
        $this->query = $this->jobsversion->delete($id);
        $this->view->result = $this->query;
    }

    public function deleteproductAction ()
    {

        $id = $this->_getParam('id');
        $this->query = $this->jobs->delete($id);
        $this->view->result = $this->query;
    }
}

