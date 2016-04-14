<?php

/**
 * Formulário selecionar o Laboratório
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 20/10/2009
 */
class App_Forms_NomeLabs extends Zend_Form
{

    /**
     * Define os erros para apresentar ao utilizadores
     */
    const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';

    const ERR_LENGHT_PASSWD = '* A palavra passe tem de ter entre 4 e 12 caracteres.';

    const ERR_COD_F3 = '* Este campo tem de ter entre 5 e 7 algarismos.';

    const ERR_EMAIL_MALFORMED = '* O endereço de email não é válido';

    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";

    /**
     * Define os estilos CSS para a form
     */
    const CLASS_BOX_TYPE_MINI = 'rounded-textbox_mini';

    const CLASS_BOX_TYPE_SMALL = 'rounded-textbox_small';

    const CLASS_BOX_TYPE_MEDIUM = 'rounded-textbox_medium';

    const CLASS_BOX_TYPE_SMALL_MEDIUM = 'rounded-textbox_small_medium';

    const CLASS_BOX_TYPE_LARGE = 'rounded-textbox_large';

    /**
     *
     * @return array
     */
    private function _getLabs ()
    {
        $labs = new App_User_Service_LabsName();
        $labsName = $labs->getAll();
        foreach ($labsName as $value)
        {
          $keepvalues[$value['num']] = $value['num'] . ' - ' . $value['nome'];
        }
        
        return $keepvalues;
    }

    /**
     * Formulário selecionar o Laboratório
     * 
     * @return Zend_Form
     */
    public function init ()
    {

       
        $labs = new Zend_Form_Element_Select('labs');
        $labs->setLabel('Escolha o Laboratório:')->setRequired(TRUE)->addErrorMessage(self::ERR_EMPTY_FIELD)->setMultiOptions($this->_getLabs());
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $this->setMethod('post')->setAction('/labs/base')->addElements(array(
            $labs , 
            $submit))->setAttrib('id', 'labsform');
        $this->setElementDecorators(array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
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