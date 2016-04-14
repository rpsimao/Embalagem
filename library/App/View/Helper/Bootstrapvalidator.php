<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 27/05/14
 * Time: 11:53
 */

class App_View_Helper_Bootstrapvalidator extends Zend_View_Helper_Abstract{


	public function Bootstrapvalidator($flag = False)
	{

		if ($flag == TRUE) {

			return '<link rel="stylesheet" href="/assets/bootstrapvalidator/dist/css/bootstrapValidator.min.css"/><script type="text/javascript" src="/assets/bootstrapvalidator/dist/js/bootstrapValidator.min.js"></script>';
		}
	}

}