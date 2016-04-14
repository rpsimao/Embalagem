<?php

class App_Forms_ChapasRec extends App_Abstract_NewForms 
{

    /**
     * 
     * @var int
     */
    protected $registo;

    /**
     * 
     * @var string
     */
    protected $cliente;

    /**
     * 
     * @var int
     */
    protected $cores;

    /**
     * 
     * @var int
     */
    protected $verniz;

    /**
     * 
     * @var date
     */
    protected $data;

    /**
     * 
     * @var void
     */
    protected $submit;

    

    /**
     * Constroi o formulário
     */
    function buildForm ()
    {

        $registo = new Zend_Form_Element_Text('obra');
        $registo->setLabel('Registo: *');
        $registo->setRequired(TRUE);
        $registo->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED , 
            self::ERR_COD_F3));
        $registo->setValidators(array(
            new Zend_Validate_Int() , 
            new Zend_Validate_StringLength(5, 5)));
        $registo->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        //
        $cliente = new Zend_Form_Element_Text('cliente');
        $cliente->setLabel('Cliente: *');
        $cliente->setRequired(TRUE);
        $cliente->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $cliente->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        //
        $cores = new Zend_Form_Element_Select('cores');
        $cores->setLabel('Nº Cores: *');
        $cores->setRequired(TRUE);
        $cores->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED));
        $cores->setValidators(array(
            new Zend_Validate_Int()));
        $cores->addMultiOptions(self::generateNumbersArray());
        $cores->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        //
        $verniz = new Zend_Form_Element_Checkbox('verniz');
        $verniz->setLabel('Verniz: *');
        $verniz->setRequired(TRUE);
        $verniz->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        //
        $data = new Zend_Form_Element_Text('dia');
        $data->setLabel('Data: *');
        $data->setRequired(TRUE);
        $data->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $data->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        return array(
            $registo , 
            $cliente , 
            $cores , 
            $verniz , 
            $data , 
            $submit);
    }

   
    

    /**
     * Gera um array o númro de cores
     * @return array
     */
    private function generateNumbersArray ()
    {

        $i = 0;
        $numbers = array();
        for ($i = 0; $i <= 10; $i ++) {
            $numbers[$i] = $i;
        }
        return $numbers;
    }
}