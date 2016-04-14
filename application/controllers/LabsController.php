<?php
/**
 * LabsController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class LabsController extends Zend_Controller_Action
{

    public function init ()
    {

        $this->registos    = new App_User_Service_Registos();
        $this->labname     = new App_User_Service_LabsName();
        $this->optimus     = new App_User_Service_Optimus();
        $this->cortantes   = new App_User_Service_Cortantes();
        $this->view->obras = new App_User_Service_Obras();
        $this->form        = new App_Forms_NomeLabs();
    }

    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {

       
        $this->view->form = $this->form;
    }

    private function cleanData ($data)
    {

        $clean = ($data == "0000-00-00") ? "" : $data;
        return $clean;
    }

    public function baseAction ()
    {

        
        if ($this->form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $numlab = $filterValues->filter($this->_request->getPost('labs'));
            $sess = new Zend_Session_Namespace('labNumber');
            $sess->labNumber = $numlab;
        }
        
        $session = new Zend_Session_Namespace('labNumber');
        
        $page = $this->_getParam('page', 1);
        
        $paginator = new App_Service_Paginator_Tables($this->registos->getAll($session->labNumber), 20, $page);

        $this->view->paginator = $paginator->paginate();
        $this->view->labName = $this->labname->getLabName($session->labNumber);
    /**
     * New Lab name
     * Cache Lab Name
     */
    //$lab = $labName['nome'];
    }

    public function newAction ()
    {

        $sqlParams = $this->registos->getOneCode($this->_getParam('codf3'));
        $formElements = App_Forms_NewCode::getForm();
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/insertrecord')->addElements($formElements)->setAttrib('id', 'newcode')->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'ul')) , 
            'Form'))->populate(array(
            'cod_interno' => $this->_getParam('codf3') , 
            'produto' => $sqlParams['produto'] , 
            'cod_cliente' => $sqlParams['cod_cliente'] , 
            'dimensoes' => $sqlParams['dimensoes'] , 
            'cores' => $sqlParams['cores'] , 
            'verniz_maquina' => $sqlParams['verniz_maquina'] , 
            'verniz_uv' => $sqlParams['verniz_uv'] , 
            'plastificacao' => $sqlParams['plastificacao'] , 
            'estampagem' => $sqlParams['estampagem'] , 
            'braille' => $sqlParams['braille'] , 
            'cortante' => $sqlParams['cortante']));
        $this->view->form = $form;
    }

    private function labNumber ($number)
    {

        $labNumber = substr($number, 0, 2);
        return $labNumber;
    }

    public function viewAction ()
    {
        
        $this->view->optimus = $this->optimus;
        $this->view->cortantes = $this->cortantes;

        if ($this->_getParam('id') > 0) {
            $action = $this->_getParam('id');
            $result = $this->registos->getOneCode($action);
            $this->view->id = $this->_getParam('id');
            $this->view->result = $result;
            //
            $getAll = $this->registos->getCodInterno($action);
            $this->view->getAll = $getAll;
            $page = $this->_getParam('page', 1);
            $paginator = Zend_Paginator::factory($getAll);
            $paginator->setItemCountPerPage(10);
            $paginator->setCurrentPageNumber($page);
            $this->view->paginator = $paginator;
            //
            $labNumber = $this->labNumber($action);
            $this->view->labNumber = $labNumber;
            ;
        } else 
            if ($this->_getParam('cc') > 0) {
                $action = $this->_getParam('cc');
                $getAll = $this->registos->getValuesByCC($action);
                $this->view->id = $this->_getParam('cc');
                $this->view->getAll = $getAll;
                $page = $this->_getParam('page', 1);
                $paginator = Zend_Paginator::factory($getAll);
                $paginator->setItemCountPerPage(10);
                $paginator->setCurrentPageNumber($page);
                $this->view->paginator = $paginator;
            }
    }

    public function insertrecordAction ()
    {

        $formElements = App_Forms_NewCode::getForm();
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/insertrecord')->addElements($formElements)->setAttrib('id', 'newcode')->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'ul')) , 
            'Form'));
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $codinterno = $filterValues->filter($this->_request->getPost('cod_interno'));
            $produto = $filterValues->filter($this->_request->getPost('produto'));
            $versao = $filterValues->filter($this->_request->getPost('versao'));
            $edicao = $filterValues->filter($this->_request->getPost('edicao'));
            $dimensoes = $filterValues->filter($this->_request->getPost('dimensoes'));
            $codcliente = $filterValues->filter($this->_request->getPost('cod_cliente'));
            $cores = $filterValues->filter($this->_request->getPost('cores'));
            $cortante = $filterValues->filter($this->_request->getPost('cortante'));
            $verniz_maquina = $filterValues->filter($this->_request->getPost('verniz_maquina'));
            $verniz_uv = $filterValues->filter($this->_request->getPost('verniz_uv'));
            $braille = $filterValues->filter($this->_request->getPost('braille'));
            $data = $filterValues->filter($this->_request->getPost('data_entrega'));
            $obra = $filterValues->filter($this->_request->getPost('obra'));
            $plastificacao = $filterValues->filter($this->_request->getPost('plastificacao'));
            $estampagem = $filterValues->filter($this->_request->getPost('estampagem'));
            $this->registos->insert($codinterno, $versao, $edicao, $codcliente, $produto, $cores, $verniz_maquina, $verniz_uv, $braille, $dimensoes, $cortante, $data, $obra, $plastificacao, $estampagem);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function editrecordAction ()
    {

        $id = $this->_getParam('id');
        $sqlParams = $this->registos->getValuesByID($id);
        $formElements = App_Forms_NewCode::getForm();
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/updaterecord/' . $id)->addElements($formElements)->setAttrib('id', 'newcode')->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'table', 'id'=>'new-code-table', 'class'=>'new-code-table-class')) , 
            'Form'))->populate(array(
            'cod_interno' => $sqlParams['cod_interno'] , 
            'produto' => $sqlParams['produto'] , 
            'cod_cliente' => $sqlParams['cod_cliente'] , 
            'dimensoes' => $sqlParams['dimensoes'] , 
            'cores' => $sqlParams['cores'] , 
            'verniz_maquina' => $sqlParams['verniz_maquina'] , 
            'verniz_uv' => $sqlParams['verniz_uv'] , 
            'plastificacao' => $sqlParams['plastificacao'] , 
            'estampagem' => $sqlParams['estampagem'] , 
            'braille' => $sqlParams['braille'] , 
            'cortante' => $sqlParams['cortante'] , 
            'versao' => $sqlParams['versao'] , 
            'edicao' => $sqlParams['edicao'] , 
            'data_entrega' => $sqlParams['data_entrega'] , 
            'obra' => $sqlParams['obra']));
        $this->view->form = $form;
    }

    public function updaterecordAction ()
    {

        $id = $this->_getParam('id');
        $formElements = App_Forms_NewCode::getForm();
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/updaterecord/' . $id)->addElements($formElements)->setAttrib('id', 'newcode')->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'table')) , 
            'Form'));
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $codinterno = $filterValues->filter($this->_request->getPost('cod_interno'));
            $produto = $filterValues->filter($this->_request->getPost('produto'));
            $versao = $filterValues->filter($this->_request->getPost('versao'));
            $edicao = $filterValues->filter($this->_request->getPost('edicao'));
            $dimensoes = $filterValues->filter($this->_request->getPost('dimensoes'));
            $codcliente = $filterValues->filter($this->_request->getPost('cod_cliente'));
            $cores = $filterValues->filter($this->_request->getPost('cores'));
            $cortante = $filterValues->filter($this->_request->getPost('cortante'));
            $verniz_maquina = $filterValues->filter($this->_request->getPost('verniz_maquina'));
            $verniz_uv = $filterValues->filter($this->_request->getPost('verniz_uv'));
            $braille = $filterValues->filter($this->_request->getPost('braille'));
            $data = $filterValues->filter($this->_request->getPost('data_entrega'));
            $obra = $filterValues->filter($this->_request->getPost('obra'));
            $plastificacao = $filterValues->filter($this->_request->getPost('plastificacao'));
            $estampagem = $filterValues->filter($this->_request->getPost('estampagem'));
            $this->registos->update($id, $codinterno, $versao, $edicao, $codcliente, $produto, $cores, $verniz_maquina, $verniz_uv, $braille, $dimensoes, $cortante, $data, $obra, $plastificacao, $estampagem);
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function deleterecordAction ()
    {

        $id = $this->_getParam('id');
        $sqlMode = $this->registos->delete($id);
        $this->view->msg = $sqlMode;
    }
}
?>

