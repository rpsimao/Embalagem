<?php
/**
 * @abstract Classe Abstracta com as constantes dos erros e estilos das caixas de texto
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */

class App_Abstract_FormsISO implements App_Interfaces_IForm
{
    /**
     * Define os erros para apresentar ao utilizadores
     *
     */
    const ERR_EMPTY_FIELD          = '* Este campo nใo pode estar vazio.';
    const ERR_LENGHT_PASSWD        = '* A palavra passe tem de ter entre 4 e 12 caracteres.';
    const ERR_COD_F3               = '* Este campo tem de ter 5 algarismos.';
    const ERR_EMAIL_MALFORMED      = '* O endere็o de email nใo ้ vแlido';
    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo s๓ pode conter algarismos.";
    /**
     * Define os estilos CSS para a form
     */
    const CLASS_BOX_TYPE_MINI   = 'rounded-textbox_mini';
    const CLASS_BOX_TYPE_SMALL  = 'rounded-textbox_small';
    const CLASS_BOX_TYPE_MEDIUM = 'rounded-textbox_medium';
    const CLASS_BOX_TYPE_LARGE  = 'rounded-textbox_large';
    /**
     * Formulรกrios.
     *
     * @var Zend_Form
     */
    protected $form;

    /**
     * 
     * @see App_Interfaces_IForm::getForm()
     */
    public static function getForm ()
    {}
}
?>