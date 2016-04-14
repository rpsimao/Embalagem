<?php
require_once ('Zend/Validate/Abstract.php');

/**
 *
 * @author rpsimao
 *        
 */
class App_Validators_AqrBraillesLabs extends Zend_Validate_Abstract
{

    const NOT_MATCH_OPTIMUS = 'clientdoesnotexists';

    const MATCH_DB = 'clientexists';

    protected $_messageTemplates = array(
        self::NOT_MATCH_OPTIMUS => '*O cliente %value% não existe no Optimus.' , 
        self::MATCH_DB          => '*O cliente %value% já existe.');

    public function isValid ($value)
    {
	    $this->_setValue($value);

	    $config = Zend_Registry::get('optimus');
        $db     = Zend_Db::factory($config->database);
        
        
        $config2 = Zend_Registry::get('embalagem');
        $db2     = Zend_Db::factory($config2->database);
        
        
        $optimus = new Zend_Validate_Db_RecordExists(array(
            'table' => 'cu' , 
            'field' => 'cu_code' , 
            'adapter' => $db));
        $opt = $optimus->isValid($value);
        
        
        $emb = new Zend_Validate_Db_NoRecordExists(array(
            'table' => 'arqbrailles_labs' , 
            'field' => 'optimus' , 
            'adapter' => $db2));
        $emblab = $emb->isValid($value);

        
        if ($opt == false) {
            $this->_error(self::NOT_MATCH_OPTIMUS);
            return false;
        
        } else 
            if ($emblab == false) {
                $this->_error(self::MATCH_DB);
                return false;
        } 
        
        return true;
    }
}