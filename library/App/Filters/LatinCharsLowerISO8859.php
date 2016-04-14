<?php

/** 
 * @author rpsimao
 * 
 * 
 */
define("LATIN1_UC_CHARS", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ");
define("LATIN1_LC_CHARS", "אבגדהוזחטיךכלםמןנסעףפץצרשתûü‎");

class App_Filters_LatinCharsLowerISO8859 implements Zend_Filter_Interface
{

	public function filterArray(array $values = array())
	{
		foreach ($values as $key => $value){

			$str = strtolower(strtr($value, LATIN1_UC_CHARS, LATIN1_LC_CHARS));

			$filter[$key] = strtr($str, array("‗" => "SS"));

		}

		return $filter;

	}

	public function filter($value)
    {
        $str = strtolower(strtr($value, LATIN1_UC_CHARS, LATIN1_LC_CHARS));
        return strtr($str, array("‗" => "SS"));
        
        
    }
    
}
?>