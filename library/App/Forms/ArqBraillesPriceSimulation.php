<?php

/** 
 * @author rpsimao
 * 
 */
class App_Forms_ArqBraillesPriceSimulation extends Twitter_Form implements App_Interfaces_ITwitterForm
{

    public function init()
    {

	    $this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>"", 'id' => 'braille-price-simulation'));
	    $this->setAction('/ajax/braillepricesimulation');
        
        /*$altura = new Zend_Form_Element_Text('altura');
        $altura->setLabel('Altura:')->setRequired(TRUE);
        $this->addElement($altura);
        
        $largura = new Zend_Form_Element_Text('largura');
        $largura->setLabel('Largura:')->setRequired(TRUE);
        $this->addElement($largura);*/

	    $placas = new Zend_Form_Element_Text('placas');
	    $placas->setLabel('Nº Peças:')->setRequired(TRUE);
	    $this->addElement($placas);

	    $texto = new Zend_Form_Element_Textarea('texto');
	    $texto->setLabel('Texto:')->setRequired(TRUE)->setAttribs(array('rows' => 6, 'cols' =>30 , 'class'=> ""));
	    $this->addElement($texto);
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')->setAttribs(array('class'=> 'skip'));
        $this->addElement($submit);

    }
}