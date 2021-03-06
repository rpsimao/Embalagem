<?php

class App_Forms_MiniLaetus extends Zend_Form
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


	public function init ()
	{

		$this->setMethod('post');
		$this->setAttribs(array("role"=>"form", "class"=>""));
        $this->setAction('/laetus/regenerate');
        /**
         * 
         * Número do cortante
         * @var int
         */
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Num. Cortante: *');
        $cortante->setRequired(TRUE);
        $cortante->addValidator(new Zend_Validate_Int());
        $cortante->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $cortante->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);    
        /**
         * 
         * Enviar
         * 
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar');
        //
        $this->addElements(array(
            $cortante , 
            $submit));
    }
}