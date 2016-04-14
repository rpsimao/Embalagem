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
class App_User_Service_RegistosBase extends App_Master_DB_Embalagem
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
        $this->registosbase = new RegistosbaseModel();
    }

    /**
     * Recupera todos registos baseado no código interno
     * @param int $codinterno
     * @return array
     */
    public function getCodInterno ($codinterno)
    {

        $sql = $this->registosbase->select()->where("codinterno = '$codinterno'");
        $sql->order('codinterno DESC');
        return $this->registosbase->fetchAll($sql);
    }
    
	/**
     * Recupera um registo baseado no código interno
     * @param int $codinterno
     * @return array
     */
    public function getOneCode ($codinterno)
    {

        $sql = $this->registosbase->select()->where("codinterno = '$codinterno'");
        return $this->registosbase->fetchRow($sql);
    }

    /**
     * Retorna todos os valores de cada laboratorio
     * @param $lab
     * @return array
     */
    public function getAll ($lab)
    {

        $sql = $this->registosbase->select()->where("codinterno LIKE '$lab%'");
        $sql->order('codinterno DESC');
        $data = $this->registosbase->fetchAll($sql);
        return $data;
    }

    /**
     * Retorna o ultimo numero de cada laboratorio
     * @param int $lab
     * @return int
     */
    public function getLastID ($lab)
    {

        $sql = $this->registosbase->select()->where("codinterno LIKE '$lab%'");
        $sql->order('codinterno DESC');
        $data = $this->registosbase->fetchRow($sql);
        $last = $data['codinterno'];
        $last += 1;
        return $last;
    }

    /**
     * 
     * @param int $codinterno
     * @param int $versao
     * @param int $edicao
     * @param string $dimensoes
     * @param string $cores
     * @param string vernizmaq
     * @param string $vernizuv
     * @param string $braille
     * @param int $cortante
     * @return void
     */
    public function insert ($codinterno, $versao, $edicao, $dimensoes, $cores, $vernizmaq, $vernizuv, $braille, $cortante)
    {

        $params = array(
            'codinterno' => $codinterno , 
            'versao' => $versao , 
            'edicao' => $edicao , 
            'dimensoes' => $dimensoes ,
            'cores' => $cores , 
            'vernizmaq' => $vernizmaq , 
            'vernizuv' => $vernizuv , 
            'braille' => $braille , 
            'cortante' => $cortante);
        $this->registosbase->insert($params);
    }
    
    /**
     * @param int $id
     * @param int $codinterno
     * @param int $versao
     * @param int $edicao
     * @param string $dimensoes
     * @param string $cores
     * @param string vernizmaq
     * @param string $vernizuv
     * @param string $braille
     * @param int $cortante
     * @return void
     */
    public function update ($id, $codinterno, $versao, $edicao, $dimensoes, $cores, $vernizmaq, $vernizuv, $braille, $cortante)
    {

        $params = array(
            'codinterno' => $codinterno , 
            'versao' => $versao , 
            'edicao' => $edicao , 
            'dimensoes' => $dimensoes ,
            'cores' => $cores , 
            'vernizmaq' => $vernizmaq , 
            'vernizuv' => $vernizuv , 
            'braille' => $braille , 
            'cortante' => $cortante);
        $where = $this->registosbase->getAdapter()->quoteInto('id = ?', $id);
        $this->registosbase->update($params, $where);
    }
    

    public function delete ($id)
    {

        $where = $this->registosbase->getAdapter()->quoteInto('id = ?', $id);
        $this->registosbase->delete($where);
    }
}
?>