<?php

/**
 * Formulário para crira Laboratórios
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 12/01/2010
 */
class App_Forms_NewLab extends Zend_Form
{

    /**
     * Define os erros para apresentar ao utilizadores
     *
     */
    const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';

    const ERR_LENGHT_PASSWD = '* A palavra passe tem de ter entre 4 e 12 caracteres.';

    const ERR_COD_F3 = '* Este campo tem de ter 5 algarismos.';

    const ERR_EMAIL_MALFORMED = '* O endereço de email não é válido';

    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";

    /**
     * Define os estilos CSS para a form
     */
    const CLASS_BOX_TYPE_MINI = 'rounded-textbox_mini';

    const CLASS_BOX_TYPE_SMALL = 'rounded-textbox_small';

    const CLASS_BOX_TYPE_MEDIUM = 'rounded-textbox_medium';

    const CLASS_BOX_TYPE_LARGE = 'rounded-textbox_large';

    const CLASS_BOX_TYPE_DATA = 'rounded-textbox_data';
    
    public function init ()
    {

        $this->setAction('/labshome/insert');
        $this->setMethod('POST');
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
        $labNumber = new Zend_Form_Element_Text('num');
        $labNumber->setLabel('Insira o Nº do Laboratório: *')
            ->setRequired(TRUE)
            ->setErrorMessages(array(
            self::ERR_EMPTY_FIELD))
            ->setAttrib('class', self::CLASS_BOX_TYPE_MINI)
            ->setDecorators($decorators);
        $labName = new Zend_Form_Element_Text('nome');
        $labName->setLabel('Insira o Nome do Laboratório: *')
            ->setRequired(TRUE)
            ->setErrorMessages(array(
            self::ERR_EMPTY_FIELD))
            ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
            ->setDecorators($decorators);
        $labId = new Zend_Form_Element_Hidden('id');
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar')
            ->setDecorators(array(
            array(
                'ViewHelper') , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'li' , 
                    'class' => 'submit'))));
        $this->addElements(array(
            $labName , 
            $labNumber , 
            $labId,
            $submit))
            ->setAttrib('id', 'labform')
            ->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'ul')) , 
            'Form'));
        ;
    }
}
?>