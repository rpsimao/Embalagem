<?php

class App_Forms_Cartolina extends App_Forms_Master_Form
{
    
    public function init()
    {
        $this->setMethod('POST');
        $this->setAction('/cartolina/insert/new');
        
        
        
       /* $tipo = new Zend_Form_Element_Select('tipo');
        $tipo->setLabel('Tipo:');
        $tipo->setMultiOptions(array(''=>'Selecione o tipo de cartolina','GC1'=>'GC1','GC2'=>'GC2','GD2'=>'GD2','IOR'=>'IOR', 'Couche'=>'Couche','GT2'=>'GT2'));
        $tipo->setMultiOptions($this->_getCartolinaType());
        $tipo->addErrorMessages(array(self::ERR_EMPTY_FIELD));
        $tipo->setRequired(TRUE);
        $this->addElement($tipo);*/
        
        $tipo = new Zend_Form_Element_Text('tipo');
        $tipo->setLabel('Tipo:')
        ->setRequired(TRUE)
        ->addErrorMessages(array(self::ERR_EMPTY_FIELD));
        $this->addElement($tipo);
        
        $gramagem = new Zend_Form_Element_Text('gramagem');
        $gramagem->setLabel('Gramagem:')
                 ->setRequired(TRUE)
                 ->addValidator('Int')
                 ->addErrorMessages(array(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED));
        $this->addElement($gramagem);
        
        
        $espessura = new Zend_Form_Element_Text('espessura');
        $espessura->setLabel('Espessura:')
                  ->setRequired(True)
                  ->addErrorMessages(array(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED));
        $this->addElement($espessura);
        
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $this->addElement($submit);
        
        $id = new Zend_Form_Element_Hidden('id');
        $this->addElement($id);
        
    }
    
    
   
    
    
}
?>