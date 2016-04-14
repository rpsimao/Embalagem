<?php



class CodigolaetusController extends Zend_Controller_Action
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
		$this->view->form = new App_Forms_LaetusTB();

	}


	public function createAction()
	{

		$form = new App_Forms_LaetusTB();
		$model = new App_User_Service_Laetus();

		if ($form->isValid($this->_request->getPost())) {
			$model->insert($form->getValues());
			if ($form->getValue('pdf') == 1) {
				$this->_helper->layout->disableLayout();
				$pdf = new App_PDF_Laetus();
				$pdf->setLaetusNumber($model->getLastLaetusCodeFromCortanteNumberForPDFCreation($form->getValue('cortante')));
				$pdf->setFormValues($form->getValues());
				$this->view->pdf = $pdf->drawBars();
				$this->view->flag = 1;
			} else {
				$this->_helper->flashMessenger->addMessage('Registo criado com sucesso.');
				$this->redirect("/codigolaetus");
			}
		} else {
			// passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}
	}



	public function checkAction(){

		$this->view->form = new App_Forms_MicroLaetusTB();


	}


	public function verifyAction()
	{
		$microform =  new App_Forms_MicroLaetusTB();

		if ($microform->isValid($this->_request->getPost())) {
			//$this->_helper->viewRenderer->setNoRender();
			$this->_helper->layout->disableLayout();


			$pdf = new App_PDF_Laetus();
			$pdf->setLaetusNumber($microform->getValue('numero'));
			$this->view->pdf = $pdf->checklaetusRender();


		} else {
			// passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $this->microform->getMessages();
			$this->view->form = $this->microform;
		}

	}

	public function recreatelaetusAction ()
	{

		$this->_helper->viewRenderer->setRender('index');
		$form = new App_Forms_MiniLaetusTB();
		$form->setAction('/codigolaetus/regenerate');
		$this->view->form = $form;
	}

	public function regenerateAction ()
	{

		$this->_helper->viewRenderer->setRender('verify');
		$miniform = new App_Forms_MiniLaetusTB();
		$miniform->setAction('/codigolaetus/regenerate');

		if ($miniform->isValid($this->_request->getPost())) {
			$model = new App_User_Service_Laetus();
			$exists = $model->checkIfValueExists($miniform->getValue('cortante'));
			if (count($exists) > 0) {
				$this->_helper->layout->disableLayout();
				$pdf = new App_PDF_Laetus();
				$pdf->setLaetusNumber($model->getLastLaetusCodeFromCortanteNumberForPDFCreation($miniform->getValue('cortante')));
				$pdf->setFormValues($model->getValue($miniform->getValue('cortante')));
				$this->view->pdf = $pdf->drawBars();
			} else {
				$this->view->check = 1;
			}
		} else {
			// passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $miniform->getMessages();
			$this->view->form = $miniform;
		}
	}

	public function editAction()
	{
		$miniform = new App_Forms_EditLaetusTB();
		$miniform->setAction('/codigolaetus/list');
		$this->view->form = $miniform;


	}




	public function itemAction()
	{
		$singleform = new App_Forms_SingleLaetusTB();
		$model = new App_User_Service_Laetus();
		$params = $model->getSingleArchive($this->_getParam('id'));
		$form = $singleform->populate($params);
		$this->view->form = $form;

	}


	public function updateAction()
	{
		$singleform = new App_Forms_SingleLaetusTB();


		if ($singleform->isValid($this->_request->getPost())) {
			$model = new App_User_Service_Laetus();
			$model->update($singleform->getValues());

			$this->_helper->flashMessenger->addMessage('Registo alterado com sucesso.');
			$this->redirect("/codigolaetus");
		} else {
			// passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $singleform->getMessages();
			$this->view->form = $singleform;
		}

	}

	public function deleteAction ()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');
		$model = new App_User_Service_Laetus();
		$model->delete($id);
	}

	public function searchAction ()
	{
		$this->view->form = new App_Forms_SearchLaetusTB();
	}

	public function listsearchAction ()
	{

		$miniform = new App_Forms_SearchLaetusTB();
		$this->view->form = $miniform;

	}

	public function listAction ()
	{
		$miniform = new App_Forms_SearchLaetusTB();


		if ($miniform->isValid($this->_request->getPost())) {
			$model = new App_User_Service_Laetus();
			$this->view->laetus = $model->getAllValuesByCortanteNumber($miniform->getValue('cortante'));
			$this->view->cortante = $miniform->getValue('cortante');

		} else {

			$this->view->errors = $miniform->getMessages();
			$this->view->form = $miniform;
		}
	}

}