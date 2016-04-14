<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 18/06/15
 * Time: 15:37
 */

class App_View_Helper_TWTitle extends Zend_View_Helper_Abstract {



	public function TWTitle(){



		$title = $this->view->navigation()->breadcrumbs()->setMinDepth(0)->setPartial(array('partials/title.phtml', 'default'));

		return $title;



	}


}