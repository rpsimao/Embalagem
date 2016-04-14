<?php
/**
 * ArqchapasController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class ArqchapasController extends Zend_Controller_Action
{


	private $arqTable;


	public function preDispatch ()
    {

        $this->arqTable = new App_User_Service_ArqChapas();
    }

    public function indexAction ()
    {

        $result = $this->arqTable->getAll();
        $page = $this->_getParam('page', 1);
        $paginator = Zend_Paginator::factory($result);
        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);
        $this->view->paginator = $paginator;
    }

    public function editrecordAction ()
    {

        $this->codf3 = $this->_getParam('codf3');
        $values = $this->arqTable->getSingleArchive($this->codf3);
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
            'tipo' => $values['tipo'] , 
            'arquivo' => $values['arquivo']);
        $ArqChapas = App_Forms_ArqChapasEditRecord::getForm();
        $buildArqChapasForm = new Zend_Form();
        $buildArqChapasForm->setAction('/arqchapas/update')->setMethod('post')->addElements($ArqChapas)->populate($params)->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'ul')) , 
            'Form'));
        ;
        $this->view->arqChapas = $buildArqChapasForm;
    }

    public function searchAction ()
    {

        $codf3 = $this->_request->getPost('codf3');
        $result = $this->arqTable->getChapas($codf3);
        $this->view->record = $result;
    }

    public function updateAction ()
    {

        $ArqChapas = App_Forms_ArqChapasEditRecord::getForm();
        $buildArqChapasForm = new Zend_Form();
        $form = $buildArqChapasForm->setAction('/arqchapas/update')->setMethod('post')->addElements($ArqChapas);
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
            $this->arqTable->update(array(
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
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function newAction ()
    {

        $ArqChapas = App_Forms_ArqChapasEditRecord::getForm();
        $buildArqChapasForm = new Zend_Form();
        $form = $buildArqChapasForm->setAction('/arqchapas/insert')->setMethod('post')->addElements($ArqChapas);
        $this->view->form = $form;
    }

    public function insertAction ()
    {

        $ArqChapas = App_Forms_ArqChapasEditRecord::getForm();
        $buildArqChapasForm = new Zend_Form();
        $form = $buildArqChapasForm->setAction('/arqchapas/insert')->setMethod('post')->addElements($ArqChapas);
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
            $this->arqTable->insert(array(
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
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function deleterecordAction ()
    {

        $id = $this->_getParam('id');
        $this->query = $this->arqTable->delete($id);
        $this->view->result = $this->query;
    }
}
?>

