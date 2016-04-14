<?php

/**
* Confirma se a obra já existe na base de dados da embalagem
* @param int $numObra
* @return int
*/
class App_Auxiliar_CheckJobNumber
{

    private $jobnumber;

    /**
     * Setter
     * @param int $jobNumber
     */
    public function setJobNumber ($jobNumber)
    {

        $this->jobnumber = $jobNumber;
    }

    /**
     * Getter
     */
    private function _getJobNumber ()
    {

        return $this->jobnumber;
    }

    /**
     * Check record
     * @return number
     */
    public function check ()
    {

        $config = Zend_Registry::get('embalagem');
        $db = Zend_Db::factory($config->database);
        
        $validator = new Zend_Validate_Db_RecordExists(array(
            'table' => 'obras' , 
            'field' => 'obra',
            'adapter' => $db
            
        ));
        if ($validator->isValid($this->_getJobNumber())) {
            return 1;
        } else {
            return 0;
        }
    }
}

?>