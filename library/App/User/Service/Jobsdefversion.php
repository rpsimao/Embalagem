<?php

/**
 * Classe para efectuar pedidos á tabela Jobsdefversion da base de dados embalagem (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 26/08/2009
 */
class App_User_Service_Jobsdefversion extends App_Master_DB_Embalagem
{

    /**
     * Define a tabela a usar
     * @var Zend_Db_Table
     */
    protected $jobs;

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
        $this->jobs = new JobsdefversionTable();
    }

    /**
     * Recupera todos registos baseado no código interno
     * @param int $codinterno
     * @return array
     */
    public function getCodInterno ($codinterno)
    {

        $sql = $this->jobs->select()->where("codinterno = '$codinterno'");
        $sql->order('registo DESC');
        return $this->jobs->fetchAll($sql);
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function getValuesByID ($id)
    {

        $sql = $this->jobs->select()->where("id = '$id'");
        $data = $this->jobs->fetchRow($sql);
        return $data;
    }

    /**
     * Recupera todos registos baseado no número da obra
     * @param int $numobra
     * @return array
     */
    public function getNumObra ($numobra)
    {

        $sql = $this->jobs->select()->where("registo = '$numobra'");
        $data = $this->jobs->fetchRow($sql);
        return $data;
    }

    /**
     * Inseres os valores na base de dados
     * @param int $codinterno
     * @param int $codcliente
     * @param int $numversao
     * @param int $numedicao
     * @param date $data
     * @param int $numobra
     * @return void
     */
    public function insert ($codinterno, $codcliente, $numversao, $numedicao, $data, $numobra)
    {

        $params = array(
            'codinterno' => $codinterno , 
            'codcliente' => $codcliente , 
            'codcliente2' => null , 
            'numversao' => $numversao , 
            'numedicao' => $numedicao , 
            'data' => $data , 
            'registo' => $numobra);
        $this->jobs->insert($params);
    }

    /**
     * 
     * @param $id
     * @param $codinterno
     * @param $codcliente
     * @param $numversao
     * @param $numedicao
     * @param $data
     * @param $numobra
     * @return void
     */
    public function update ($id, $codinterno, $codcliente, $numversao, $numedicao, $data, $numobra)
    {

        $params = array(
            'codinterno' => $codinterno , 
            'codcliente' => $codcliente , 
            'codcliente2' => null , 
            'numversao' => $numversao , 
            'numedicao' => $numedicao , 
            'data' => $data , 
            'registo' => $numobra);
        $where = $this->jobs->getAdapter()->quoteInto('id = ?', $id);
        $this->jobs->update($params, $where);
    }

    public function delete ($id)
    {

        $where = $this->jobs->getAdapter()->quoteInto('id = ?', $id);
        $this->jobs->delete($where);
    }
}
?>