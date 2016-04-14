<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 19/06/15
 * Time: 14:34
 */

class App_Calculations_ChapasRecuperadas {

	CONST FIRST_YEAR = 2010;

	/**
	 * Calculate how may plates were recovered by year
	 * @return array
	 */

	public function calculateByYear(){

		$chapas = new chapasrec();

		$currentYear = date("Y");

		$forLoop = (int) $currentYear - self::FIRST_YEAR;

		$values = array();

		for ($i = 0; $i <= $forLoop; $i++){

			$values[self::FIRST_YEAR + $i] = $chapas->getNumberOfPlatesByYear(self::FIRST_YEAR + $i);
		}

			return $values;

	}



}