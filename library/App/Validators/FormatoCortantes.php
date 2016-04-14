<?php
require_once ('Zend/Validate/Abstract.php');

class App_Validators_FormatoCortantes extends Zend_Validate_Abstract
{

    const NOT_MATCH = 'formatDoesNotExists';

    protected $_messageTemplates = array(
        self::NOT_MATCH => 'Não existe registo de formato para este cortante. Insira as medidas.');

    public function isValid ($value)
    {

        $this->cortante = new App_User_Service_Cortantes();
        $this->medidascortante = new App_User_Service_MedidasCortantes();
        $firstAttempt = $this->cortante->getMeasuresByCortanteNumber($value);
        
        if ($firstAttempt == 0) {
            $this->_error(self::NOT_MATCH);
            return false;
        }
        return true;
    }
}
?>