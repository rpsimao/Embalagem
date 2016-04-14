<?php

class App_Forms_BrailleProva extends Twitter_Form implements App_Interfaces_ITwitterForm
{

    function init ()
    {

	    $this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>""));
	    $this->setAction('/braille/provacreate');

	    $texto = new Zend_Form_Element_Textarea('texto');
        $texto->setLabel('Texto:');
        $texto->setRequired(TRUE);
        $texto->setErrorMessages(array(self::ERR_EMPTY_FIELD));
        $texto->setAttribs(array(
            'rows' => 10 ,
            'cols' => 35));
	    $this->addElement($texto);

        //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
	    $this->addElement($submit);



    }
}