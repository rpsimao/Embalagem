<?php
/**
 * qualidadeModel
 * 
 * @author rpsimao
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class qualidadeModel extends Zend_Db_Table_Abstract
{

    /**
     * The default table name 
     */
    protected $_name = 'qualidade';

    function __construct ()
    {

        $config = Zend_Registry::get('embalagem');
        $db = Zend_Db::factory($config->database);
        parent::__construct($db);
    }

    public function getAllRecords ($lab)
    {

        $select = $this->select();
        $select->where('lab = ?', $lab);
        return $this->fetchAll($select);
    }
}

