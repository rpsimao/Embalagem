<?php

class App_Forms_SearchLaetusTB extends Twitter_Form implements App_Interfaces_ITwitterForm
{


	const CLASS_BOX_TYPE_MINI = 'input-small';

	const CLASS_BOX_TYPE_SMALL = 'input-small';

	const CLASS_BOX_TYPE_MEDIUM = '';

	const CLASS_BOX_TYPE_LARGE = 'input-large';

	const CLASS_BOX_TYPE_DATA = 'rounded-textbox_data';


	public function init ()
	{

		$this->setMethod('post');
		$this->setAttribs(array("role"=>"form", "class"=>""));
        $this->setAction('/codigolaetus/list');
        /**
         * 
         * Número do cortante
         * @var int
         */
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Num. Cortante: *');
        $cortante->setRequired(TRUE);
        $cortante->addValidators(array(new Zend_Validate_Int(), new App_Validators_CodigoLaetusCheck()));
        $cortante->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        /**
         * 
         * Enviar
         * 
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Procurar');
        //
        $this->addElements(array(
            $cortante , 
            $submit));
    }
}