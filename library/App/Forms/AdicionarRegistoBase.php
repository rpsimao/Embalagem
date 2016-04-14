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

class App_Forms_AdicionarRegistoBase extends App_Abstract_Forms implements App_Interfaces_IForm
{
     /**
     * 
     * @see App_Interfaces_IForm::getForm()
     * @return array
     */
    public static function getForm ()
    {
        $decorators = array(
            array(
                'ViewHelper') , 
            array(
                'Errors') , 
            array(
                'Label') , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'li')));
        
        $codinterno = new Zend_Form_Element_Text('codinterno');
        $codinterno->setLabel('Código Interno:*')
             ->setRequired(TRUE)
             ->addValidator(new Zend_Validate_StringLength(5, 5))
             ->addValidator(new Zend_Validate_Int())
             ->setErrorMessages(array(self::ERR_COD_F3, self::ERR_ONLY_NUMBERS_ALLOWED))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
             ->setDecorators($decorators);
             
             
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Produto:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
             ->setDecorators($decorators); 

             
        $dimensoes = new Zend_Form_Element_Text('dimensoes');
        $dimensoes->setLabel('Dimensões:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
             ->setDecorators($decorators);  

        $cores = new Zend_Form_Element_Text('cores');
        $cores->setLabel('Cores:*')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
             ->setDecorators($decorators);
             
             
        //
       $options = array("Não", "Sim");
       $vernizmaq = new Zend_Form_Element_Radio('vernizmaq');
       $vernizmaq->setLabel('Verniz Máquina:*')
       ->setRequired(true)
       ->setOptions(array('separator' => '&nbsp;&nbsp;'))
       ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
       ->setMultiOptions($options)
       ->setDecorators($decorators);
        //
       $vernizuv = new Zend_Form_Element_Radio('vernizuv');
       $vernizuv->setLabel('Verniz UV:*')
       ->setRequired(true)
       ->setOptions(array('separator' => '&nbsp;&nbsp;'))
       ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
       ->setMultiOptions($options)
       ->setDecorators($decorators);
        //
        //
       $braille = new Zend_Form_Element_Radio('braille');
       $braille->setLabel('Braille:*')
       ->setRequired(true)
       ->setOptions(array('separator' => '&nbsp;&nbsp;'))
       ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
       ->setMultiOptions($options)
       ->setDecorators($decorators);
        //
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Nº Cortante: *')
        ->setRequired(TRUE)
        ->addValidator(new Zend_Validate_Int())
        ->addErrorMessage(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED)
        ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
        ->setDecorators($decorators);
             
             
          

        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')	;

        
        return array($codinterno, $produto, $dimensoes, $cores, $vernizmaq, $vernizuv, $braille, $cortante, $submit);
    
}

}
?>