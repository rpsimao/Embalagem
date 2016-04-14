<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 19/06/14
 * Time: 15:04
 */

class App_View_Helper_ArqBrailleTitleSearch extends Zend_View_Helper_Abstract
{
	public function ArqBrailleTitleSearch($postvalue)

	{

		$request    = Zend_Controller_Front::getInstance()->getRequest();
		$action     = $request->getActionName();

		switch($action)
		{
			case ('searchobra'):

				return "Obra Nº" . $postvalue;
				break;

			case ('searchlab'):
				return "Laboratório " . $postvalue;

				break;

			case ('searchbraille'):

				return "Braille Nº" . $postvalue;

				break;

			case ('searchcodigocliente'):
				return "Código Cliente: " . $postvalue;
				break;

			case ('searchtxt'):
				return "Texto: " . $postvalue;
				break;

			case ('searchcodif3'):
				return "Código F3: " . $postvalue;
				break;


		}



	}
} 