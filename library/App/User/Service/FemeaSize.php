<?php

/**
 * Classe para efectuar pedidos à tabela femeasize da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 18/08/2009
 */
class App_User_Service_FemeaSize extends App_Master_DB_Embalagem
{

   

    /**
     * Número da obra
     * @var int
     */
    protected $obra;

    /**
     * Numero de linhas na vertical
     * @var int
     */
    protected $vertical;

    /**
     * Numero de linha na horizontal
     * @var int
     */
    protected $horizontal;

    /**
     * Liga à base de dados define a tabela
     * @return Zend_Db_Table
     */
    function __construct ()
    {

        parent::__construct();
        $this->femeaSize = new FemeasizeTable();
    }

    /**
     * Insere os valores
     * @param int $obra
     * @param float $preco_macho
     * @param float $preco_femea
     * @return void
     */
    public function insert ($obra, $vertical, $horizontal)
    {

        try {
            $params = array(
                'obra' => $obra , 
                'vertical' => $vertical , 
                'horizontal' => $horizontal);
            $this->femeaSize->insert($params);
        } catch (Exception $e) {
            $this->update($obra, $vertical, $horizontal);
        }
    }

    /**
     * Actualiza os valores
     * @param int $obra
     * @param float $preco_macho
     * @param float $preco_femea
     * @return void
     */
    public function update ($obra, $vertical, $horizontal)
    {

        $params = array(
            'obra' => $obra , 
            'vertical' => $vertical , 
            'horizontal' => $horizontal);
        $where = $this->femeaSize->getAdapter()->quoteInto('obra = ?', $obra);
        $this->femeaSize->update($params, $where);
    }

    /**
     * Recupera os valores da base de dados consoante o número da obra
     * @param int $obra
     * @return array
     */
    public function getAll ($obra)
    {

        $sql = $this->femeaSize->select()->where('obra = ?', $obra);
        $row = $this->femeaSize->fetchRow($sql);
        return $row;
    }
}
?>