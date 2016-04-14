<?php
/**
 * Formulário para o arquivo de chapas
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 22/10/2009
 */
class App_Forms_ArqChapasEditRecord extends App_Abstract_Forms implements App_Interfaces_IForm
{

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
        $codigof3 = new Zend_Form_Element_Text('codigof3');
        $codigof3->setLabel('Insira o Código F3:*')
                ->setRequired(TRUE)
                ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
                ->setDecorators($decorators);
                //
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Insira o Nº do Cortante:*')
                ->setRequired(TRUE)
                ->addFilter(new Zend_Filter_StripTags())
                ->addFilter(new Zend_Filter_HtmlEntities())
                ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
                ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
                ->setDecorators($decorators);
                //
        $versao = new Zend_Form_Element_Text('versao');
        $versao->setLabel('Insira o Nº da Versão:*')
                ->setRequired(TRUE)
                ->addValidator(new Zend_Validate_Int())
                ->setErrorMessages(array(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED))
                ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
                ->setDecorators($decorators);
                //
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Insira o Nome do Produto:*')
                ->setRequired(TRUE)
                ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
                ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
                ->setDecorators($decorators);
                //
        $_700x1000 = new Zend_Form_Element_Text('700x1000');
        $_700x1000->setLabel('700x1000:')
                   ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                   ->setDecorators($decorators);
                   //
        $_1000x700 = new Zend_Form_Element_Text('1000x700');
        $_1000x700->setLabel('1000x700:')
                  ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                  ->setDecorators($decorators);
                  //
        $_800x700 = new Zend_Form_Element_Text('800x700');
        $_800x700->setLabel('800x700:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_700x800 = new Zend_Form_Element_Text('700x800');
        $_700x800->setLabel('700x800:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_000x000 = new Zend_Form_Element_Text('000x000');
        $_000x000->setLabel('000x000:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_550x800 = new Zend_Form_Element_Text('550x800');
        $_550x800->setLabel('550x800:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_698x498 = new Zend_Form_Element_Text('698x498');
        $_698x498->setLabel('698x498:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_698x398 = new Zend_Form_Element_Text('698x398');
        $_698x398->setLabel('698x398:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $_698x332 = new Zend_Form_Element_Text('698x332');
        $_698x332->setLabel('698x332:')
                 ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
                 ->setDecorators($decorators);
                 //
        $options = array(
            'AUTOPLATINA' => 'Autoplatina' , 
            'CILINDRICA' => 'Cilindrica' , 
            'CONTENTORA' => 'Contentora' , 
            'CANELADO' => 'Canelado');
        //
        $tipo = new Zend_Form_Element_Radio('tipo');
        $tipo->setLabel('Tipo:*')
             ->setRequired(true)
             ->setOptions(array('separator' => '&nbsp;&nbsp;'))
             ->setErrorMessages(array(self::ERR_EMPTY_FIELD))
             ->setMultiOptions($options)
             ->setDecorators($decorators);
             //
        $arquivo = new Zend_Form_Element_Text('arquivo');
        $arquivo->setLabel('Caixa Nº:*')
                ->setRequired(TRUE)
                ->addValidator(new Zend_Validate_Int())
                ->setErrorMessages(array(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED))
                ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
                ->setDecorators($decorators);
                //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        return array(
            $codigof3 , 
            $cortante , 
            $versao , 
            $produto , 
            $_700x1000 , 
            $_1000x700 , 
            $_800x700 , 
            $_700x800 , 
            $_000x000 , 
            $_550x800 , 
            $_698x498 , 
            $_698x398 , 
            $_698x332 , 
            $tipo , 
            $arquivo , 
            $submit);
    }
}