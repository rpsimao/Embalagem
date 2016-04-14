<?php

/** 
 * @author rpsimao
 * 
 */
class App_Forms_ArqbraillesSearchByLab extends Zend_Form
{
    
    protected $labs;
    
    
    public function init()
    {
        $this->setAction('arqbraille/searchlab');
        $this->setAttribs(array('onsubmit'=>"return validateInput('labs')"));
        $this->setMethod('POST');
        
        
        $select = new Zend_Form_Element_Select('labs');
        $select->addMultiOptions($this->_getLabs());
        $select->setAttrib('class', "form-control search-query input-small");
        $this->addElement($select);        
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $this->addElement($submit);
        
        $this->setDecorators(array('FormElements', 'Form'));
        $decorators = array(array('ViewHelper'), array('Errors'), 
        array('Label'), 
        array('HtmlTag'));
        
    }
    
    
    
    
    private function _getLabs()
    {
        $this->labs = new Arqbrailles();
        $rows = $this->labs->getLabs();
        
        $setLabs = array();
	    $setLabs[""] = "Escolha o laboratório";
        
        foreach ($rows as $value) {
            
            $setLabs[$value['nbraille_lab']] = $value['nbraille_lab'];
        }
        
        
        return $setLabs;
        
    }
    
    
}
?>