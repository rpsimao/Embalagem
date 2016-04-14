<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 29/06/15
 * Time: 16:14
 */

class App_Filters_RemoveAllWhitespaces implements Zend_Filter_Interface {

	public function filter($value)
	{

		$valueFiltered = preg_replace('/\s+/', '', $value);
		return $valueFiltered;
	}

}