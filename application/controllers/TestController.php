<?php
/**
 * TestController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';

class TestController extends Zend_Controller_Action

{

	public function init()
	{
		$this->_helper->layout()->setLayout('layout-iso-bootstrap');
	}

    public function indexAction()
    {


	    /*$config = Zend_Registry::get('Zend_Navigation');

	    $y = $config->findBy('id', "braille_prova")->get("uri");


	   echo $y;*/


	    $navigation = Zend_Registry::get('Zend_Navigation');
	    $request    = Zend_Controller_Front::getInstance()->getRequest()->getRequestUri();

	    $y = $navigation->findBy('id', "test")->get("uri");


	    $active = ($request == $y) ? "active" : "";


	    echo $active;
    }


	public function testAction(){

		$navigation = Zend_Registry::get('Zend_Navigation');
		$request    = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();

		$y = $navigation->findBy('id', "test")->get("controller");


		//$active = ($request == $y) ? "active" : "";


		echo $y ."->Request: " . $request;;




	}
}