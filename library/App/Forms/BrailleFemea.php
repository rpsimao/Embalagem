<?php

/**
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 20/06/2014
 */
class App_Forms_BrailleFemea extends Twitter_Form implements App_Interfaces_ITwitterForm
{


    public function init ()
    {


		$this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>""));
	    $this->setAction('/braille/femeacreate');

	    $obra = new Zend_Form_Element_Text('numobra');
        $obra->setLabel('Insira o N&ordm; da Obra:')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($obra);
        
        $altura = new Zend_Form_Element_Text('altura');
        $altura->setLabel('Altura Caixa: *');
        $altura->setRequired(TRUE);
        $altura->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($altura);

        //
        $largura = new Zend_Form_Element_Text('largura');
        $largura->setLabel('Largura Caixa: *');
        $largura->setRequired(TRUE);
        $largura->setErrorMessages(array(self::ERR_EMPTY_FIELD));
	    $this->addElement($largura);

        //
        
        $quantidade = new Zend_Form_Element_Text('qtd');
        $quantidade->setLabel('Quantidade:');
        $quantidade->setRequired(TRUE);
        $quantidade->setErrorMessages(array(self::ERR_EMPTY_FIELD));
        $quantidade->setValidators(array(new Zend_Validate_Int()));
        $this->addElement($quantidade);
        
        
        
        $tipoCortante = new Zend_Form_Element_Radio('cortante');
        $tipoCortante->setLabel('Tipo de Cortante:')
                     ->setSeparator(' ')
                     ->addMultiOption(1, 'Cilindrica[CC]')
                     ->addMultiOption(0, 'Autoplatina[CA]')
                     ->setRequired(TRUE)
                     ->setErrorMessages(array(self::ERR_EMPTY_FIELD)); 
        $this->addElement($tipoCortante);

        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
	    $this->addElement($submit);

	}
}
