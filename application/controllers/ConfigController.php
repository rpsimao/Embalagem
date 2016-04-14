<?php

class ConfigController extends Zend_Controller_Action
{

    public function init()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
    }

    public function indexAction()
    {

    }


	public function optionsAction(){

		$dbconfig = new ConfigArquivoBraille();
		$this->view->names = $dbconfig->getAll();

	}



	public function ajaxnewarqbraillelabsnamesAction(){

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$nome = $this->_getParam('name');


		$db = new ConfigArquivoBraille();
		$db->insert(array("id"=>null, 'nome' => $nome));

		$this->getResponse()->appendBody($db->getAdapter()->lastInsertId());

	}

	public function ajaxupdatearqbraillelabsnamesAction(){

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$nome = $this->_getParam('name');
		$id = $this->_getParam("id");


		$db = new ConfigArquivoBraille();
		$update = $db->updateRecord($id, array("nome" => $nome));

		$this->getResponse()->appendBody($update);

	}

	public function ajaxdeletearqbraillelabsnamesAction(){

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam("id");


		$db = new ConfigArquivoBraille();
		$update = $db->deleteRecord($id);

		$this->getResponse()->appendBody($update);

	}

}

