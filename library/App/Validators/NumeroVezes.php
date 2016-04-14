<?php
require_once ('Zend/Validate/Abstract.php');

class App_Validators_NumeroVezes extends Zend_Validate_Abstract
{

    const BIG_NUMBER = 'numberTooBig';

    const SMALL_NUMBER = 'numberTooSmall';

    protected $_messageTemplates = array(
        self::BIG_NUMBER => 'Verifique o número de vezes.',
        self::SMALL_NUMBER => 'Verifique o número de vezes.'
        );

    public function isValid ($value)
    {

        if ($value > 150) {
            $this->_error(self::BIG_NUMBER);
            return false;
        } else 
            if ($value < 1) {
                $this->_error(self::SMALL_NUMBER);
                return false;
            }
        return true;
    }
}
?>