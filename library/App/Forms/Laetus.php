<?php

class App_Forms_Laetus extends Zend_Form
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
        $this->setAction('/laetus/create');
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
        $cortante->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_MINI, 'onblur' => 'getMedidasCortante()'));
        /**
         * @deprecated
         * formato da embalagem
         * @var string
         */
        $formato = new App_Forms_Elements_Diecut('formato');
        $formato->setLabel('Formato:');
        $formato->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_MINI));
       
        /**
         * 
         * Número do código
         * @deprecated Irá apenas ser válido para a inserção dos valoes que estão nos dossiers
         * @deprecated Depois será removida.
         * @var int
         */
        $codigo = new Zend_Form_Element_Text('codigolaetus');
        $codigo->setLabel('Num. Código Laetus: *');
        $codigo->setRequired(TRUE);
        $codigo->setValidators(array(
            new Zend_Validate_Int()));
        $codigo->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $codigo->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * 
         * Nome do Laboratório
         * @var string
         */
        $laboratorio = new Zend_Form_Element_Text('laboratorio');
        $laboratorio->setLabel('Laboratório: *');
        //$laboratorio->setRequired(TRUE);
        //$laboratorio->setErrorMessages(array(
          //  self::ERR_EMPTY_FIELD));
        $laboratorio->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_MEDIUM));
        /**
         * 
         * Nome do Produto
         * @var string
         */
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Produto: *');
        $produto->setRequired(TRUE);
        $produto->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $produto->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_LARGE));
        /**
         * 
         * Código F3
         * @var string
         */
        $codf3 = new Zend_Form_Element_Text('codf3');
        $codf3->setLabel('Código F3: *');
        $codf3->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $codf3->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_MEDIUM));
        /**
         * Criar PDF
         */
        $pdf = new Zend_Form_Element_Checkbox('pdf');
        $pdf->setLabel('Criar PDF:');
        $pdf->setChecked(TRUE);
        
        
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
            $formato , 
            //$codigo , 
            $laboratorio , 
            $produto , 
            $codf3 , 
            $pdf,
            $submit));
    }
}