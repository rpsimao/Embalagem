<?php
require_once ('Zend/Form.php');

class App_Forms_Master_Form extends Zend_Form
{
    
    /**
     * Define os erros para apresentar ao utilizadores
     *
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
    
    
    
    
}
?>