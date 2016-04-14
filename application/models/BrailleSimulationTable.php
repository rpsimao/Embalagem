<?php
/**
 * Table Braille
 *
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 01/07/2014
 */
require_once 'Zend/Db/Table/Abstract.php';

class BrailleSimulationTable extends Zend_Db_Table_Abstract
{

    /**
     * The default table name 
     */
    protected $_name = 'braille_simulation';
	protected $_primary = 'id';
}
