<?php

class App_User_Service_LabsName extends App_Master_DB_Embalagem
{

    /**
     * Define a tabela a usar
     * @var Zend_Db_Table
     */
    protected $labs;

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
        $this->labs = new laboratoriosnameTable();
    }

    /**
     * Retorna os nome dos laboratórios e respectivo numero
     * @return array
     */
    public function getAll ()
    {

        $sql = $this->labs->select();
        $sql->order('num');
        $rows = $this->labs->fetchAll($sql);
        return $rows;
    }

    public function getbyID ($id)
    {

        $sql = $this->labs->select();
        $sql->where('id =?', $id);
        $row = $this->labs->fetchRow($sql);
        return $row;
    }

    public function getAllSortByName ()
    {

        $sql = $this->labs->select();
        $sql->order('nome');
        $row = $this->labs->fetchAll($sql);
        return $row;
    }

    public function getLabName ($number)
    {

        $sql = $this->labs->select()->where("num = '$number'");
        $row = $this->labs->fetchRow($sql);
        return $row;
    }

    /**
     * Apaga registo
     * @param int $id
     */
    public function delete ($id)
    {

        $where = $this->labs->getAdapter()->quoteInto('id = ?', $id);
        $this->labs->delete($where);
    }

    /**
     * Actualiza os Labs
     * @param array $values
     */
    public function update (array $values = array())
    {

        $params = array(
            'id' => $values['id'] , 
            'num' => $values['num'] , 
            'nome' => $values['nome']);
        $where = $this->labs->getAdapter()->quoteInto('id = ?', $values['id']);
        $this->labs->update($params, $where);
    }
    
    
    
    public function insert(array $values = array())
    {
        
        $params = array(
        
            'num' => $values['num'],
            'nome' => $values['nome']
        );
    if ($values['id'] == NULL) {
            $this->labs
            ->insert($params);;
        } else {
            $arrayID = array('id' => $values['id']);
            $result = array_merge($params, $arrayID);
            $this->update($result);
        }
    }
    
    
}
?>