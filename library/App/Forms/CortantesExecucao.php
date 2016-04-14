<?php

class App_Forms_CortantesExecucao extends Zend_Form
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

    const ERR_DATE_MALFORMED = "*A data não está correcta. Utilize AAAA-MM-DD";

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

        $this->setAction('/cortantes/execinsert');
        $this->setMethod('POST');
        /**
         * 
         * Cortante Nº
         * @var Zend_Form_Element_Text
         */
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Cortante:');
        $cortante->setRequired(TRUE);
        $cortante->setValidators(array(
            new Zend_Validate_Int()));
        $cortante->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $cortante->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo Autoplatina
         * @var Zend_Form_Element_Text
         */
        $autoplatina = new Zend_Form_Element_Text('autoplatina');
        $autoplatina->setLabel('Autoplatina:');
        $autoplatina->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo cilindrica
         * @var Zend_Form_Element_Text
         */
        $cilindrica = new Zend_Form_Element_Text('cilindrica');
        $cilindrica->setLabel('Cilíndrica:');
        $cilindrica->setValidators(array(new Zend_Validate_Float()));
        $cilindrica->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $cilindrica->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo a
         * @var Zend_Form_Element_Text
         */
        /*$a = new Zend_Form_Element_Text('a');
        $a->setLabel('A:');
        $a->setValidators(array(new Zend_Validate_Float()));
        $a->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $a->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo b
         * @var Zend_Form_Element_Text
         */
       /* $b = new Zend_Form_Element_Text('b');
        $b->setLabel('B:');
        $b->setValidators(array(new Zend_Validate_Float()));
        $b->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $b->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo h
         * @var Zend_Form_Element_Text
         */
        /*$h = new Zend_Form_Element_Text('h');
        $h->setLabel('H:');
        $h->setValidators(array(new Zend_Validate_Float()));
        $h->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $h->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo f
         * @var Zend_Form_Element_Text
         */
        
        $abh = new App_Forms_Elements_Diecut('abh');
        $abh->setLabel('A-B-H');
        $abh->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_MINI));
        
        $f = new Zend_Form_Element_Text('f');
        $f->setLabel('f:');
        $f->setValidators(array(new Zend_Validate_Float()));
        $f->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $f->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo g
         * @var Zend_Form_Element_Text
         */
        $g = new Zend_Form_Element_Text('g');
        $g->setLabel('g:');
        $g->setValidators(array(new Zend_Validate_Float()));
        $g->addErrorMessages(array(
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $g->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo Pala
         * @var Zend_Form_Element_Text
         */
        $pala = new Zend_Form_Element_Text('pala');
        $pala->setLabel('Pala:');
        $pala->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Campo Tipo
         * @var Zend_Form_Element_Text
         */
        $tipo = new Zend_Form_Element_Text('tipo');
        $tipo->setLabel('Tipo:');
        $tipo->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * 
         * caixas Nº
         * @var Zend_Form_Element_Text
         */
        $caixas = new Zend_Form_Element_Text('caixas');
        $caixas->setLabel('Nº caixas:');
        $caixas->setValidators(array(
            new Zend_Validate_Int()));
        $caixas->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $caixas->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * 
         * requisicao Nº
         * @var Zend_Form_Element_Text
         */
        $requisicao = new Zend_Form_Element_Text('requisicao');
        $requisicao->setLabel('Requisição Nº:');
        $requisicao->setValidators(array(
            new Zend_Validate_Int()));
        $requisicao->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $requisicao->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Data envio
         * @var unknown_type
         */
        $dataEnvio = new Zend_Form_Element_Text('dataenvio');
        $dataEnvio->setLabel('Data Envio:');
        $dataEnvio->setRequired(TRUE);
        $dataEnvio->setValidators(array(
            new Zend_Validate_Date('YYYY-MM-DD')));
        $dataEnvio->setErrorMessageSeparator(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_DATE_MALFORMED));
        $dataEnvio->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * Data Pedida
         * @var unknown_type
         */
        $dataPedida = new Zend_Form_Element_Text('datapedida');
        $dataPedida->setLabel('Data Pedida:');
        $dataPedida->setRequired(TRUE);
        $dataPedida->setValidators(array(
            new Zend_Validate_Date('YYYY-MM-DD')));
        $dataPedida->setErrorMessageSeparator(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_DATE_MALFORMED));
        $dataPedida->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        
        
        $obra = new Zend_Form_Element_Text('obra');
        $obra->setLabel('Nº Obra');
        $obra->setAttribs(array(
            'class' => self::CLASS_BOX_TYPE_SMALL));
        /**
         * 
         * Enter description here ...
         * @var Zend_Form_Element_Submit
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar Pedido');
        //
        
        $id = New Zend_Form_Element_Hidden('id');
        
        $this->addElements(array(
            $cortante , 
            $autoplatina , 
            $cilindrica , 
            $abh , 
           // $b , 
            //$h , 
            $f , 
            $g , 
            $pala , 
            $tipo , 
            $caixas , 
            $requisicao , 
            $dataEnvio , 
            $dataPedida ,
            $obra, 
            $submit,$id));
    }
}
?>