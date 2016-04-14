<?php

class App_Forms_Cliche extends App_Abstract_NewForms 
{

    /**
     * Constroi o formulário;
     */
    function buildForm ()
    {
        
        $lab = new Zend_Form_Element_Text('laboratorio');
        $lab->setLabel('Laboratório: * ');
        $lab->setRequired(TRUE);
        $lab->setErrorMessages(array(self::ERR_EMPTY_FIELD));
        $lab->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Cortante: *');
        $cortante->setRequired(TRUE);
        $cortante->setErrorMessages(array(self::ERR_EMPTY_FIELD));
        $cortante->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        
        return array($lab, $cortante, $submit);
        
        
    }

   
}