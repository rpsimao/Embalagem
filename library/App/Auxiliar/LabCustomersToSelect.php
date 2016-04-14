<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 01/04/15
 * Time: 12:50
 */

class App_Auxiliar_LabCustomersToSelect {


	private $html;

	private $values;

	/**
	 * @param array $values
	 */
	public function __construct(array $values=array())
	{

		$this->values = $values;
	}

	/**
	 * @param string $id
	 * @param string $lab
	 * @return string
	 */
	public function buildSelect($id, $lab)
	{

		$html = '<select id="'.$id.'">';
		$html.= '<option value="GRUPO TECNIMEDE">GRUPO TECNIMEDE</option>';

		foreach ($this->values as $cu)
		{
			if($cu["j_customer"] == $lab){
				$html.='<option value="'.utf8_encode($cu["j_customer"]).'" selected>'.utf8_encode($cu["j_customer"]).'</option>';

			} else {
				$html.='<option value="'.utf8_encode($cu["j_customer"]).'">'.utf8_encode( $cu["j_customer"]).'</option>';
			}

		}


		$html.= '</select>';

		return $html;


	}

}