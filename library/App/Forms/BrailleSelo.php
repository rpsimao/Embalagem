<?php

class App_Forms_BrailleSelo extends Twitter_Form
{

    const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';
    
    const ERR_LENGHT_PASSWD        = '* A palavra passe tem de ter entre 4 e 12 caracteres.';
    
    const ERR_COD_F3               = '* Este campo tem de ter 5 algarismos.';
    
    const ERR_EMAIL_MALFORMED      = '* O endereço de email não é válido';
    
    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";
    
    const ERR_DATE_MALFORMED       = "* A data não está correcta. Utilize AAAA-MM-DD";
    
    const ERR_NO_RECORD_EXISTS     = "* O número de Braille não existe.";
    

    
    public function init()
    {
        
        $config = Zend_Registry::get('embalagem');
        Zend_Db::factory($config->database);
        
        $this->setMethod('POST');
        $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>"", 'id'=>'selo_braille_form'));
        $this->setAction('/arqbraille/renderpdf');
        
        $numbraille = new Zend_Form_Element_Text('numbraille');
        $numbraille->setLabel('Insira o Nº do Braille:');
        $numbraille->setRequired('TRUE');
        $numbraille->addValidators(array(new Zend_Validate_Int(), new Zend_Validate_Db_RecordExists(array('table'=>'arqbrailles', 'field'=>'nbraille_num'))));
        $numbraille->setErrorMessages(array(
                self::ERR_EMPTY_FIELD ,
                self::ERR_ONLY_NUMBERS_ALLOWED,
                self::ERR_NO_RECORD_EXISTS        
        ));
        $numbraille->setAttribs(array( 'onblur' => 'retrieveBrailleTxt()'));
        $this->addElement($numbraille);
        
        $select = new Zend_Form_Element_Select('verify');
        $select->setLabel('Verificado por:');
        $select->setRequired('TRUE');
        $select->setErrorMessages(array(self::ERR_EMPTY_FIELD ));
        $select->addMultiOptions(array(
                                        '' => 'Seleccione um nome:',
                                        'Rosa Freitas' => 'Rosa Freitas',
                                        'Mário Castilho' => 'Mário Castilho',
                                        'Frederico Sarmento' => 'Frederico Sarmento',
                                        ));
        $this->addElement($select);
        
        $txt = new Zend_Form_Element_Textarea('txtbraille');
        $txt->setLabel('Texto Braille:')->setAttribs(array('rows' => 10, 'cols' => 20));
        $this->addElement($txt);
        
        $txt = new Zend_Form_Element_Textarea('obs');
        $txt->setLabel('Dados Técnicos:')->setAttribs(array('rows' => 5, 'cols' => 20 ));
        $this->addElement($txt);
        
        /*$submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar Selo');
        $this->addElement($submit);*/

	    $this->addElement("submit", "criar", array("label" => "Criar Selo"));
        

        
    }
}