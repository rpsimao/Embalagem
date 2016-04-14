<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 27/05/14
 * Time: 11:53
 */

class App_View_Helper_JSQtip extends Zend_View_Helper_Abstract{


	public function JSQtip($flag = False)
	{

		if ($flag == TRUE) {

			return '<link rel="stylesheet" type="text/css" href="http://cdn.fterceiro.pt/library/plugins/qtip2/jquery.qtip.min.css" /><script type="text/javascript" src="http://cdn.fterceiro.pt/library/plugins/qtip2/jquery.qtip.min.js"></script>';
		}
	}

}