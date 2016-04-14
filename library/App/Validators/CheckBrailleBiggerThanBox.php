<?php
require_once ('Zend/Validate/Abstract.php');

class App_Validators_CheckBrailleBiggerThanBox extends Zend_Validate_Abstract
{

    const NOT_MATCH = 'brailleExceedsFormat';

    protected $_messageTemplates = array(
        self::NOT_MATCH => 'O Texto do Braille Não Cabe na Caixa.');

    public function isValid ($value)
    {    
        $calc = new App_Calculations_BraillePrice();
        $calc->setTexto($value);
        

        
        if ($firstAttempt == 0) {
            $this->_error(self::NOT_MATCH);
            return false;
        }
        return true;
    }
}
?>