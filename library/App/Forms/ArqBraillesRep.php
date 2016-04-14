<?php

/** 
 * @author rpsimao
 * 
 */
class App_Forms_ArqBraillesRep extends Twitter_Form implements App_Interfaces_ITwitterForm
{

    public function init()
    {

	    $this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>"", 'id' => 'myForm'));
	    $this->setAction('/arqbraille/repcreate');
        
        $nbraille_num = new Zend_Form_Element_Text('nbraille_num_rep');
        $nbraille_num->setLabel('Braille Nº:')->setRequired(TRUE);
        $this->addElement($nbraille_num);
        
        $obras = new Zend_Form_Element_Text('pecas_rep');
        $obras->setLabel('Peças:')->setRequired(TRUE);
        $this->addElement($obras);
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')->setAttribs(array('class'=> 'skip'));
        $this->addElement($submit);

    }
}