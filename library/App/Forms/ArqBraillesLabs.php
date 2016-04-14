<?php


/**
 *
 * @author rpsimao
 *        
 */
class App_Forms_ArqBraillesLabs extends Twitter_Form
{
   
    public function init()
    {

        $this->setMethod('POST');
        $this->setAction('/arqbraille/createlab');
	    //$this->setAttribs(array('class'=>"form-inline"));
        
        $optimus = new Zend_Form_Element_Text('optimus');
        $optimus->setLabel('Nome Optimus:');
        $optimus->setRequired(TRUE);
        $optimus->addValidator(new App_Validators_AqrBraillesLabs());
        $this->addElement($optimus);
        
        
        $lab = new Zend_Form_Element_Text('shortname');
        $lab->setLabel('Nome Braille:');
        $lab->setRequired(TRUE);
        $lab->addValidator(new Zend_Validate_StringLength(3, 3));
        $lab->setErrorMessages(array('Este campo tem de conter 3 letras'));
        $this->addElement($lab);
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $this->addElement($submit);
        
        
    }
    
}