<?php

/**
 * Formulário para abrir Job
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_Forms_Open  extends App_Forms_Master_Form
{

   
    
    
    public function init()
    {
        
        
        $obra = new Zend_Form_Element_Text('numobra');
        $obra->setLabel('Insira o Num. da Obra:')
             ->setRequired(TRUE)
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
             
             
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
               
        
        
        
        $this->setMethod('post')
             ->setAction('/obra')
             ->addElements(array($obra, $submit))
             ->addAttribs(array('id'=>'loginform'));
             
             
         $this->setElementDecorators(array(
            'ViewHelper',
            array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
            array('Label', array('tag' => 'td')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        array('Errors')
         ));
        $submit->setDecorators(array('ViewHelper',
            array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
            array(array('emptyrow' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element', 'placement' => 'PREPEND')),
            array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
            ));
        
        
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form'
        ));
             
        
    }
}
?>