<?php

class DiecutsController extends Zend_Controller_Action
{

	protected $table;

    public function init()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
	    $this->table = new App_User_Service_Cortantes();
    }


	public function preDispatch()
	{
		if ($this->_helper->FlashMessenger->hasMessages()) {
			$this->view->messages = $this->_helper->FlashMessenger->getMessages();
		}
	}

    public function indexAction()
    {
        // action body
    }


	public function searchAction ()
	{
		$this->_helper->layout->disableLayout();

		$delimiter = $this->_getParam('delimiter');


		if ($this->_getParam('id') == 0) {
			$param = $this->_getParam('query');
			$query = $this->table->genericSearch('cortante', $param, $delimiter);
		}
		if ($this->_getParam('id') == 1) {
			$param = $this->_getParam('query');
			$query = $this->table->genericSearch('codigo', $param, $delimiter);
		}
		if ($this->_getParam('id') == 2) {
			$param = $this->_getParam('query');
			$query = $this->table->genericSearch('A', $param, $delimiter);
		}
		if ($this->_getParam('id') == 3) {
			$param = $this->_getParam('query');
			$query = $this->table->genericSearch('A_B', $param, $delimiter);
		}
		if ($this->_getParam('id') == 4) {
			$param = $this->_getParam('query');
			$query = $this->table->genericSearch('A_B_H', $param, $delimiter);
		}
		$this->view->results = $query;
	}



	public function newAction()
	{
		$this->_helper->layout->disableLayout();
		$this->view->form = new App_Forms_CortantesTB();

	}


	public function createAction(){


		$form = new App_Forms_CortantesTB();

		if ($form->isValid($_POST)) {
			$arrayformValues = $form->getValues();
			$this->table->insert($arrayformValues);

			$this->_helper->flashMessenger->addMessage('O Cortante ' . $arrayformValues['cortante'] . " foi criado com sucesso.");
			$this->redirect("/diecuts");


		} else {
			//passa as mensagem de erro e o formulário para a VIEW
			$this->view->errors = $form->getMessages();
			$this->view->form = $form;
		}


	}

	public function getcortanteforviewAction()
	{
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');
		$sql = new App_User_Service_Cortantes();
		$this->view->records = $sql->getSingleArchive($id)->toArray();

	}


	public function updatediecutAction(){

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();


		$sql = new App_User_Service_Cortantes();
		$params = array(
			'id'                  => $this->_request->getPost('id') ,
			'estante'             => $this->_request->getPost('estante') ,
			'codigo'              => $this->_request->getPost('codigo') ,
			'cortante'            => $this->_request->getPost('cortante') ,
			'A'                   => $this->_request->getPost('A') ,
			'B'                   => $this->_request->getPost('B') ,
			'H'                   => $this->_request->getPost('H') ,
			'f'                   => $this->_request->getPost('f') ,
			'g'                   => $this->_request->getPost('g') ,
			'pala'                => $this->_request->getPost('pala') ,
			'tipo'                => $this->_request->getPost('tipo') ,
			'formato_util'        => $this->_request->getPost('formato_util') ,
			'formato_otimizado'   => $this->_request->getPost('formato_otimizado') ,
			'formato_entrada'     => $this->_request->getPost('formato_entrada') ,
			'espaco'              => $this->_request->getPost('espaco') ,
			'braille1'            => $this->_request->getPost('braille1') ,
			'braille2'            => $this->_request->getPost('braille2') ,
			'braille3'            => $this->_request->getPost('braille3') ,
			'formato_std'         => $this->_request->getPost('formato_std') ,
			'descasque'           => $this->_request->getPost('descasque'),
			'obs'                 => $this->_request->getPost('obs'),
			'alteracoes'          => $this->_request->getPost('alteracoes'),
			'pl_entrada'          => $this->_request->getPost('pl_entrada'),
			'pl_impressao'        => $this->_request->getPost('pl_impressao'),
			'sentido_fibra'       => $this->_request->getPost('sentido_fibra'),
			'ex_pl'               => $this->_request->getPost('ex_pl'),




		);

		$sql->update($params);



	}


	public function deletediecutAction(){

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$id = $this->_getParam('id');
		$sql = new App_User_Service_Cortantes();
		$sql->delete($id);



	}


	public function insertcortantefolhaobraAction()
	{

		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$this->optimus   = new App_User_Service_Optimus();

		$this->cortantes = new App_User_Service_Cortantes();



		$params = $this->getAllParams();

		if (is_numeric($params['j_ucode2']))
		{
			$measures = $this->cortantes->getMeasuresByCortanteNumber($params['j_ucode2']);
			$code = $this->cortantes->searchByCortanteName($params['j_ucode2']);


			$values = $this->cortantes->getSingleArchive($params["id"]);

			$exec = $this->optimus->insertCortanteFolhaObra($params['j_ucode2'], $params['j_number'], $measures, $code['estante'], $values["pl_entrada"], $values["pl_impressao"], $values["sentido_fibra"], $values["ex_pl"], $values["formato_entrada"] );

			$msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";

			$this->getResponse()->appendBody($msg);
		} else {
			$this->insertcortantenamefolhaobraAction();
		}
	}

	public function insertcortantenamefolhaobraAction()
	{
		$params = $this->getAllParams();

		$this->optimus   = new App_User_Service_Optimus();

		$this->cortantes = new App_User_Service_Cortantes();
		$values = $this->cortantes->getSingleArchive($params["id"]);



		$code = $this->cortantes->searchByCortanteName($params['j_ucode2']);

		$measures = $this->cortantes->getMeasuresByCortanteNumber($code['codigo']);

		$exec = $this->optimus->insertCortanteFolhaObra($params['j_ucode2'], $params['j_number'], $measures, $code['estante'], $values["pl_entrada"], $values["pl_impressao"], $values["sentido_fibra"], $values["ex_pl"], $values["formato_entrada"]);

		$msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";

		$this->getResponse()->appendBody($msg);
	}

	public function removecortantefolhaobraAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$optimus   = new App_User_Service_Optimus();
		$params = $this->getAllParams();

		$exec = $optimus->removeCortanteFolhaObra($params['j_number']);

		$msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";

		$this->getResponse()->appendBody($msg);
	}


}

