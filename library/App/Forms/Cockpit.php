<?php

/**
 * Formulário para abrir cockpit do trabalho
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_Forms_Cockpit extends App_Abstract_Forms implements App_Interfaces_IForm
{

    /**
     *
     * @see App_Interfaces_IForm::getForm()
     */
    
    
    
    
    public static function getForm ()
    {
        $config = Zend_Registry::get('embalagem');
        $db = Zend_Db::factory($config->database);
        
        $obra = new Zend_Form_Element_Text('numobra');
        $obra->setLabel('Insira o Nº. da Obra: *')->setRequired(TRUE);
        $obra->addValidator(new Zend_Validate_Db_RecordExists(array('table'=>'obras', 'field'=>'obra','adapter'=>$db)))->addErrorMessage("* Não foi encontrada uma obra com o Nº%value%");
        $obra->addValidator(new Zend_Validate_NotEmpty())->addErrorMessage(self::ERR_EMPTY_FIELD);
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/cockpit/display/')->addElements(array($obra,$submit))->setAttrib('id', 'cockpitform');
        
        $form->setElementDecorators(array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        array('Errors')));
        
        $submit->setDecorators(array('ViewHelper',
        array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
        array(array('emptyrow' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element', 'placement' => 'PREPEND')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
        
        $form->setDecorators(array('FormElements',array('HtmlTag', array('tag' => 'table')),'Form'));
        
        return $form;
    }
}
?>
