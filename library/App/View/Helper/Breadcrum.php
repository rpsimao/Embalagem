<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 27/05/14
 * Time: 11:53
 */

class App_View_Helper_Breadcrum extends Zend_View_Helper_Abstract{


	public function Breadcrum()
	{

		//$request    = Zend_Controller_Front::getInstance()->getRequest();

		//$controller = $request->getControllerName();
		//$action     = $request->getActionName();
		//$param      = $request->getParam("date");




		return $this->view->navigation()->breadcrumbs()->setMinDepth(0)->setPartial('partial/breadcrums.phtml');


	}

}