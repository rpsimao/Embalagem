<?php

/**
 * Classe para efectuar pedidos à tabela Cartelas da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 17/08/2009
 */
class App_User_Service_Cartelas extends App_Master_DB_Embalagem
{

    /**
     * Liga a base de dados
     * @return Zend_DB_Table
     */
    public function __construct ()
    {

        parent::__construct();
        $this->table = new CartelasTable();
    }

    /**
     * Recupera os valores
     * @param int $codigo
     * @return mixed
     */
    public function getAllByBarcode ($codigo)
    {

        $sql = $this->table->select()->where('codbarras = ?', $codigo);
        $row = $this->table->fetchAll($sql);
        return $row;
    }
    
    public function getAllByBarcodeLike ($codigo)
    {
    
        $sql = $this->table->select()->where("codbarras like '%$codigo%'");
        $row = $this->table->fetchAll($sql);
        return $row->toArray();
    }
    
    
    public function getAllByNameLike ($codigo)
    {
    
        $sql = $this->table->select()->where("nome like '%$codigo%'");
        $row = $this->table->fetchAll($sql);
        return $row->toArray();
    }
    
    public function getSingleArchive ($codigo)
    {

        $sql = $this->table->select()->where('codbarras = ?', $codigo);
        $row = $this->table->fetchRow($sql);
        return $row->toArray();
    }

    /**
     * Get All values
     * @return array
     */
    public function getAll ()
    {

        $select = $this->table->select();
        $select->order('nome Asc');
        $rows =  $this->table->fetchAll($select);
        return $rows->toArray();
    }

    

    /**
     * @param array $values
     * @return void
     */
    public function insert (array $values = array())
    {

        $params = array(
            'codf3' => $values[0] , 
            'cortante' => $values[1] , 
            'versao' => $values[2] , 
            'produto' => $values[3] , 
            '700_1000' => $values[4] , 
            '1000_700' => $values[5] , 
            '800_700' => $values[6] , 
            '700_800' => $values[7] , 
            '000_000' => $values[8] , 
            '550_800' => $values[9] , 
            '698_498' => $values[10] , 
            '698_398' => $values[11] , 
            '698_332' => $values[12] , 
            'tipo' => $values[13] , 
            'arquivo' => $values[14]);
        $this->table->insert($params);
    }

    /**
     * @param array $values
     * @return void
     */
    public function update (array $values = array())
    {

        $params = array(
            'codf3' => $values[0] , 
            'cortante' => $values[1] , 
            'versao' => $values[2] , 
            'produto' => $values[3] , 
            '700_1000' => $values[4] , 
            '1000_700' => $values[5] , 
            '800_700' => $values[6] , 
            '700_800' => $values[7] , 
            '000_000' => $values[8] , 
            '550_800' => $values[9] , 
            '698_498' => $values[10] , 
            '698_398' => $values[11] , 
            '698_332' => $values[12] , 
            'tipo' => $values[13] , 
            'arquivo' => $values[14]);
        $where = $this->table->getAdapter()->quoteInto('codf3 = ?', $values[0]);
        $this->table->update($params, $where);
    }

    public function delete ($id)
    {

        $where = $this->table->getAdapter()->quoteInto('id = ?', $id);
        $this->table->delete($where);
    }
}