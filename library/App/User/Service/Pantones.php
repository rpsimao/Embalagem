<?php
/**
 * Classe para efectuar pedidos á tabela pantones da base de dados embalagem (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 21/08/2009
 */

class App_User_Service_Pantones extends App_Master_DB_Embalagem
{
    /**
     * Define a tabela a usar
     * @var Zend_Db_Table
     */
    protected $pantones;
    /**
     * seleciona as cartolinas
     * @var array
     */
    protected $select;
    /**
     * executa um pedido à base de dados
     * @var string
     */
    protected $sql;
    /**
     * Retorna os valores do pedido à base de dados
     * @var array
     */
    protected $row;
    
    /**
     * Liga à base de dados e define a tabela a usar
     * @return Zend_Db_Table
     */
    function __construct ()
    {

        parent::__construct();
        $this->pantones = new PantonesTable();
    }
    

    /**
     * Retorna o valor hexadecimal do pantone
     * @param string $id
     * @return array
     */
    public function getHexColor($id) 
    {
        
       // $row = $this->pantones->getAdapter()->fetchRow("SELECT * FROM pantones WHERE `id` LIKE '%$id%';");
        $row = $this->pantones->getAdapter()->fetchRow("SELECT * FROM pantones WHERE `id` = ?;", $id);
        return $row;
        
    }
    
}
?>