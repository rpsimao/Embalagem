<?php

/**
 * Formulário para criação do Selo
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 03/07/2014
 */

class App_Forms_Braille extends Twitter_Form implements App_Interfaces_ITwitterForm
{


	/**
	 * @return void|Zend_Form
	 */

	public function init ()
    {

	    $this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "id"=>"create-braille-00001"));
	    $this->setAction('/braille/createbraille');

        $obra = new Zend_Form_Element_Text('numobra');
        $obra->setLabel('Insira o N&ordm; da Obra:')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', "input-small");
	    $this->addElement($obra);
             
        
        $femeaLrg = new Zend_Form_Element_Text('femeaLrg');
        $femeaLrg->setLabel('Largura Caixa:')
                 ->setAttrib('class', "input-small")
                 ->setRequired(TRUE)
                 ->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($femeaLrg);



	    $femeaAlt = new Zend_Form_Element_Text('femeaAlt');
        $femeaAlt->setLabel('Altura Caixa:')
                 ->setAttrib('class', "input-small")
                 ->setRequired(TRUE)
                 ->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($femeaAlt);



	    $femea = new Zend_Form_Element_Radio('femea');
        $femea->setLabel('&Eacute; necess&aacute;rio f&ecirc;mea?')
              ->setSeparator(' ')
              ->addMultiOption(1, 'Sim')
              ->addMultiOption(0, 'N&atilde;o')
              ->setValue(0)
              ->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($femea);




	    $tipoCortante = new Zend_Form_Element_Radio('cortante');
        $tipoCortante->setLabel('Tipo de Cortante:')
                     ->setSeparator(' ')
                     ->addMultiOption(1, 'Cil&iacute;ndrica[CC]')
                     ->addMultiOption(0, 'Autoplatina[CA]')
                     ->setRequired(TRUE)
                     ->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($tipoCortante);


	    $texto = new Zend_Form_Element_Textarea('texto');
        $texto->setLabel('Texto:')
              ->setRequired(TRUE)
              ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
              ->setAttribs(array('rows'=> 8, 'cols' => 25));
	    $this->addElement($texto);
        


	    $textoOptimus = new Zend_Form_Element_Textarea('textoOptimus');
        $textoOptimus->setLabel('Texto Optimus:')
                      ->setRequired(TRUE)
                      ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
                      ->setAttribs(array('rows'=> 8, 'cols' => 25));
	    $this->addElement($textoOptimus);
        
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar Braille');
	    $this->addElement($submit);
        
        
        $id = new Zend_Form_Element_Hidden('id');
	    $this->addElement($id);

    }
}