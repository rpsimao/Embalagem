<?php

class App_Forms_ChapasRecNew  extends Twitter_Form implements App_Interfaces_ITwitterForm
{


    function init ()
    {

	    $this->setMethod('POST');
	    $this->setAttribs(array("role"=>"form", "id"=>"new_chapas_recuparadas_form"));


        $registo = new Zend_Form_Element_Text('obra');
        $registo->setLabel('Obra: *');
        $registo->setRequired(TRUE);
        $registo->setErrorMessages(array(
            self::ERR_EMPTY_FIELD , 
            self::ERR_ONLY_NUMBERS_ALLOWED , 
            self::ERR_COD_F3));
        $registo->setValidators(array(
            new Zend_Validate_Int() , 
            new Zend_Validate_StringLength(5, 5)));
        $registo->setAttribs(array('class'=> "input-small", "autocomplete"=>"off"));
	    $this->addElement($registo);
        //
        $cliente = new Zend_Form_Element_Text('cliente');
	    //$cliente->addMultiOptions($this->generateClients());
        $cliente->setLabel('Cliente: *');
        $cliente->setRequired(TRUE);
       // $cliente->setErrorMessages(array( self::ERR_EMPTY_FIELD));
        //$cliente->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
	    $this->addElement($cliente);
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
        $cores->setAttrib('class', "input-small");
	    $this->addElement($cores);
        //
        $verniz = new Zend_Form_Element_Checkbox('verniz');
        $verniz->setLabel('Verniz: *');
        $verniz->setRequired(TRUE);
        $verniz->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
	    //$verniz->setAttrib("class", "ace");
	    $this->addElement($verniz);
        //
        $data = new Zend_Form_Element_Text('dia');
        $data->setLabel('Data: *');
        $data->setRequired(TRUE);
        $data->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        //$data->setAttrib('data-date-format', "dd-mm-yyyy");
	    $this->addElement($data);
        //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
	    $this->addElement($submit);



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



	private function generateClients(){

		$chapas = new chapasrec();
		$cliArray = $chapas->getClients();


		$setLabs = array();
		$setLabs[""] = "Escolha o cliente";

		foreach ($cliArray as $value) {

			$setLabs[$value['cliente']] = $value['cliente'];
		}

		return $setLabs;


	}
}