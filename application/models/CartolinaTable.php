<?php
/**
 * Cartolina Table
 *
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
require_once 'Zend/Db/Table/Abstract.php';

class CartolinaTable extends Zend_Db_Table_Abstract
{

    /**
     * The default table name 
     */
    protected $_name = 'cartolina';
}
