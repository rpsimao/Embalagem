<?php
require_once 'Zend/Db/Table/Abstract.php';

class Frases extends Zend_Db_Table_Abstract
{

    /**
     * The default table name
     */
    protected $_name = 'frases';

    protected $_primary = "id";
}
