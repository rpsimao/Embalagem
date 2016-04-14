<?php

class App_Forms_Emprova extends Zend_Form
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

        $this->setMethod('post');
        $this->setAction('/emprova/create');
        
        $obra = new Zend_Form_Element_Text('obra');
        $obra->setLabel('Num. Obra: *');
        $obra->setRequired(TRUE);
        $obra->setValidators(array(new Zend_Validate_Int(), new Zend_Validate_StringLength(5,5)));
        $obra->setErrorMessages(array(
            self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED, self::ERR_COD_F3));
        $obra->setAttribs(array('class' => self::CLASS_BOX_TYPE_SMALL));    
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar');
        
       
        //
        $this->addElements(array(
            $obra , 
            $submit));
    }     
}