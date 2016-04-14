<?php

class App_Forms_NewChapasRecuperadas extends Twitter_Form implements App_Interfaces_ITwitterForm
{


	public function init()
	{

		$this->setMethod('POST');
		$this->setAttribs(array("role"=>"form", "class"=>""));
		$this->setAction('/chapasrecuperadas/list');



		$obra = new Zend_Form_Element_Text('obra');
		$obra->setLabel('Nº Obra: *');
		$obra->setRequired(TRUE)->setAttribs(array('class'=> "input-small"));
		$this->addElement($obra);


		//
		$submit = New Zend_Form_Element_Submit('submit');
		$submit->setLabel('Enviar');
		$this->addElement($submit);



	}

}