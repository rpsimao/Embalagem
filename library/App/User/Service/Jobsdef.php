<?php

/**
 * Classe para efectuar pedidos á tabela Jobsdef da base de dados embalagem (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 26/08/2009
 */
class App_User_Service_Jobsdef extends App_Master_DB_Embalagem
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
        $this->jobs = new JobsdefTable();
    }

    /**
     * Recupera todos registos baseado no código interno
     * @param int $codinterno
     * @return array
     */
    public function getCodInterno ($codinterno)
    {

        $sql = $this->jobs->select()->where("codinterno = '$codinterno'");
        $sql->order('codinterno DESC');
        return $this->jobs->fetchAll($sql);
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
     * Retorna todos os valores de cada laboratorio
     * @param $lab
     * @return array
     */
    public function getAll ($lab)
    {

        $sql = $this->jobs->select()->where("codinterno LIKE '$lab%'");
        $sql->order('codinterno DESC');
        $data = $this->jobs->fetchAll($sql);
        return $data;
    }

    /**
     * Insere os valores na base de dados
     * @param int $codinterno
     * @param string $codcliente
     * @param int $numversao
     * @param int $numedicao
     * @param string $produto
     * @param int $numcortante
     * @return void
     */
    public function insert ($codinterno, $codcliente, $numversao, $numedicao, $produto, $numcortante)
    {

        $params = array(
            'codinterno' => $codinterno , 
            'codcliente' => $codcliente , 
            'versao' => $numversao , 
            'edicao' => $numedicao , 
            'produto' => $produto , 
            'numcortante' => $numcortante);
        $this->jobs->insert($params);
    }

    public function delete ($id)
    {

        $where = $this->jobs->getAdapter()->quoteInto('id = ?', $id);
        $this->jobs->delete($where);
    }
}
?>