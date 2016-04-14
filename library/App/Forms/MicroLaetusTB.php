<?php

class App_Forms_MicroLaetusTB extends Twitter_Form implements App_Interfaces_ITwitterForm
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
        $this->setAction('/codigolaetus/verify');
        /**
         * 
         * Número do cortante
         * @var int
         */
        $cortante = new Zend_Form_Element_Text('numero');
        $cortante->setLabel('Num. Laetus: *');
        $cortante->setRequired(TRUE);
        $cortante->addValidator(new Zend_Validate_Int());
        $cortante->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $cortante->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);    
        /**
         * 
         * Enviar
         * 
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Verificar');
        //
        $this->addElements(array(
            $cortante , 
            $submit));
    }
}