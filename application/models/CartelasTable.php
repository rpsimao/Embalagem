<?php
/**
 * 
 * Enter description here ...
 * 
 * @author Ricardo Sim�o - ricardo.simao@fterceiro.pt
 * @copyright 2011 - Fernandes & Terceiro, SA
 * @copyright All right reserved.
 * @license Although this script is provided with source code it does NOT mean that this report is in the public domain.
 * 
 * @version 1.0 - Nov 28, 2011 4:32:37 PM
 * 
 * 
 */
require_once 'Zend/Db/Table/Abstract.php';

class CartelasTable extends Zend_Db_Table_Abstract
{

    /**
     * The default table name 
     */
    protected $_name = 'cartelas';
}
