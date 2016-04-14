<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 18/06/15
 * Time: 15:12
 */

class ArquivochapasController extends Zend_Controller_Action
{




	public function init()
	{
		$this->_helper->layout()->setLayout('layout-iso-bootstrap');

	}


	public function preDispatch()
	{
		if ($this->_helper->FlashMessenger->hasMessages()) {
			$this->view->messages = $this->_helper->FlashMessenger->getMessages();
		}


	}

	public function indexAction()
	{
		$arqTable = new App_User_Service_ArqChapas();
		$result = $arqTable->getAll();
		$page = $this->_getParam('page', 1);
		$paginator = Zend_Paginator::factory($result);
		$paginator->setItemCountPerPage(15);
		$paginator->setCurrentPageNumber($page);
		$this->view->paginator = $paginator;
	}


	public function searchAction ()
	{
		$arqTable = new App_User_Service_ArqChapas();
		$codf3 = $this->_request->getPost('codf3');
		$result = $arqTable->getSingleArchive( $codf3);
		$this->view->results = $result;


	}

	public function editrecordAction ()
	{

		$codf3 = $this->_getParam('codf3');
		$arqTable = new App_User_Service_ArqChapas();
		$values = $arqTable->getSingleArchive($codf3);
		$params = array(
			'codigof3' => $values['codf3'] ,
			'cortante' => $values['cortante'] ,
			'versao' => $values['versao'] ,
			'produto' => $values['produto'] ,
			'700x1000' => $values['700_1000'] ,
			'1000x700' => $values['1000_700'] ,
			'800x700' => $values['800_700'] ,
			'700x800' => $values['700_800'] ,
			'000x000' => $values['000_000'] ,
			'550x800' => $values['550_800'] ,
			'698x498' => $values['698_498'] ,
			'698x398' => $values['698_398'] ,
			'698x332' => $values['698_332'] ,
			'000x000' => $values['000_000'] ,
			'tipo' => $values['tipo'] ,
			'arquivo' => $values['arquivo']);
		$arqChapas = new App_Forms_ArquivoChapasEditRecord();
		$arqChapas->setAction('/arquivochapas/update');


		$this->view->arqChapas = $arqChapas->populate($params);
	}


	public function updateAction ()
	{

		$form = new App_Forms_ArquivoChapasEditRecord();
		$form->setAction('/arquivochapas/update');

		if ($form->isValid($_POST)) {
			$filterValues = new Zend_Filter_StripTags();
			$codf3 = $filterValues->filter($this->_request->getPost('codigof3'));
			$cortante = $filterValues->filter($this->_request->getPost('cortante'));
			$versao = $filterValues->filter($this->_request->getPost('versao'));
			$produto = $filterValues->filter($this->_request->getPost('produto'));
			$_700x1000 = $filterValues->filter($this->_request->getPost('700x1000'));
			$_1000x700 = $filterValues->filter($this->_request->getPost('1000x700'));
			$_800x700 = $filterValues->filter($this->_request->getPost('800x700'));
			$_700x800 = $filterValues->filter($this->_request->getPost('700x800'));
			$_000x000 = $filterValues->filter($this->_request->getPost('000x000'));
			$_550x800 = $filterValues->filter($this->_request->getPost('550x800'));
			$_698x498 = $filterValues->filter($this->_request->getPost('698x498'));
			$_698x398 = $filterValues->filter($this->_request->getPost('698x398'));
			$_698x332 = $filterValues->filter($this->_request->getPost('698x332'));
			$tipo = $filterValues->filter($this->_request->getPost('tipo'));
			$arquivo = $filterValues->filter($this->_request->getPost('arquivo'));

			$arqTable = new App_User_Service_ArqChapas();
			$arqTable->update(array(
				$codf3 ,
				$cortante ,
				$versao ,
				$produto ,
				$_700x1000 ,
				$_1000x700 ,
				$_800x700 ,
				$_700x800 ,
				$_000x000 ,
				$_550x800 ,
				$_698x498 ,
				$_698x398 ,
				$_698x332 ,
				$tipo ,
				$arquivo));

			$this->_helper->flashMessenger->addMessage('O Registo ' . $codf3 . " foi actualizado com sucesso.");
			$this->redirect("/arquivochapas");

		} else {
			//passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}
	}

	public function newAction ()
	{

		$form = new App_Forms_ArquivoChapasEditRecord();
		$form->setAction('/arquivochapas/insert');
		$this->view->form = $form;
	}

	public function insertAction ()
	{

		$form = new App_Forms_ArquivoChapasEditRecord();
		$form->setAction('/arquivochapas/insert');

		if ($form->isValid($_POST)) {
			$filterValues = new Zend_Filter_StripTags();
			$codf3 = $filterValues->filter($this->_request->getPost('codigof3'));
			$cortante = $filterValues->filter($this->_request->getPost('cortante'));
			$versao = $filterValues->filter($this->_request->getPost('versao'));
			$produto = $filterValues->filter($this->_request->getPost('produto'));
			$_700x1000 = $filterValues->filter($this->_request->getPost('700x1000'));
			$_1000x700 = $filterValues->filter($this->_request->getPost('1000x700'));
			$_800x700 = $filterValues->filter($this->_request->getPost('800x700'));
			$_700x800 = $filterValues->filter($this->_request->getPost('700x800'));
			$_000x000 = $filterValues->filter($this->_request->getPost('000x000'));
			$_550x800 = $filterValues->filter($this->_request->getPost('550x800'));
			$_698x498 = $filterValues->filter($this->_request->getPost('698x498'));
			$_698x398 = $filterValues->filter($this->_request->getPost('698x398'));
			$_698x332 = $filterValues->filter($this->_request->getPost('698x332'));
			$tipo = $filterValues->filter($this->_request->getPost('tipo'));
			$arquivo = $filterValues->filter($this->_request->getPost('arquivo'));

			$arqTable = new App_User_Service_ArqChapas();
			$arqTable->insert(array(
				$codf3 ,
				$cortante ,
				$versao ,
				$produto ,
				$_700x1000 ,
				$_1000x700 ,
				$_800x700 ,
				$_700x800 ,
				$_000x000 ,
				$_550x800 ,
				$_698x498 ,
				$_698x398 ,
				$_698x332 ,
				$tipo ,
				$arquivo));

			$this->_helper->flashMessenger->addMessage('O Registo ' . $codf3 . " foi criado com sucesso.");
			$this->redirect("/arquivochapas");


			var_dump($_POST);
		} else {
			//passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}
	}


	public function deleterecordAction ()
	{

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');
		$arqTable = new App_User_Service_ArqChapas();
		$arqTable->delete($id);
		$this->_helper->flashMessenger->addMessage('O Registo  foi apagado com sucesso.');
		$this->redirect("/arquivochapas");
	}


}
