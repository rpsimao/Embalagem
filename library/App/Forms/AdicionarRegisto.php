<?php
/**
 * Edição e criação de registos
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 31/08/2009
 */

class App_Forms_AdicionarRegisto extends App_Abstract_Forms implements App_Interfaces_IForm
{
     /**
     * 
     * @see App_Interfaces_IForm::getForm()
     * @return array
     */
    public static function getForm ()
    {
        
        $codinterno = new Zend_Form_Element_Text('codinterno');
        $codinterno->setLabel('Código Interno:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
             
             
        $codcliente = new Zend_Form_Element_Text('codcliente');
        $codcliente->setLabel('Código Cliente:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI); 

             
        $numversao = new Zend_Form_Element_Text('numversao');
        $numversao->setLabel('Nº. Versão:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI);  

        $numedicao = new Zend_Form_Element_Text('numedicao');
        $numedicao->setLabel('Nº. Edição:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
             
             
        $numversao = new Zend_Form_Element_Text('numversao');
        $numversao->setLabel('Nº. Versão:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
             
             
        $data = new Zend_Form_Element_Text('data');
        $data->setLabel('Data:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI); 

             
        $obra = new Zend_Form_Element_Text('obra');
        $obra->setLabel('Nº. Obra:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI);  

        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')	;

        
        return array($codinterno, $codcliente, $numversao, $numedicao, $numversao, $data, $obra, $submit);
    
}

}
?>