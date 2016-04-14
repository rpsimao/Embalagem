<?php
/**
 * EmprovaTable
 * 
 * @author rpsimao
 * @version 
 */
require_once 'Zend/Db/Table/Abstract.php';

class EmprovaTable extends Zend_Db_Table_Abstract
{

    /**
     * The default table name 
     */
    protected $_name = 'emprova';

    function __construct ()
    {

        $config = Zend_Registry::get('embalagem');
        $db = Zend_Db::factory($config->database);
        parent::__construct($db);
        $this->optimus = new App_User_Service_Optimus();
    }

    public function insertFormValues (array $params)
    {

        $q = $this->optimus->getJobData($params['obra']);
        $values = array(
            'obra' => $params['obra'] , 
            'lab' => $q['j_customer'] , 
            'dia' => date('Y-m-d') , 
            'hora' => date('H:i:s') , 
            'estado' => 0);
        $this->insert($values);
    }

    public function getAllRecords ()
    {

        $select = $this->select();
        $select->where('estado != ?', 2);
        $select->order('dia DESC');
        $select->order('hora DESC');
        return $this->fetchAll($select);
    }

    /**
     * Actualiza os valores na tabela
     * @param int $obra
     * @return void
     */
    public function updateProva ($id, $estado)
    {

        $params = array(
            'estado' => $estado , 
            'dia_fim_prepress' => date('Y-m-d') , 
            'hora_fim_prepress' => date('H:i:s'));
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update($params, $where);
    }

    /**
     * Actualiza os valores na tabela
     * @param int $obra
     * @return void
     */
    public function updateDepTec ($id, $estado)
    {

        $params = array(
            'estado' => $estado , 
            'dia_fim_deptec' => date('Y-m-d') , 
            'hora_fim_deptec' => date('H:i:s'));
        $where = $this->getAdapter()->quoteInto('id = ?', $id);
        $this->update($params, $where);
    }

    public function searchBetweenDates ($date1, $date2)
    {

        $q = $this->select();
        $q->where("dia BETWEEN '$date1' AND '$date2'");
        $q->order('dia');
        $q->order('hora');
        return $this->fetchAll($q);
    }

    public function getAllRecordsByLab ($lab)
    {

        $select = $this->select();
        $select->where('lab = ?', $lab);
        $select->order('dia DESC');
        $select->order('hora DESC');
        return $this->fetchAll($select);
    }

    public function getAllByDate ($date)
    {

        $q = $this->select();
        $q->where("dia = ?", $date);
        $q->order('dia DESC');
        $q->order('hora DESC');
        return $this->fetchAll($q);
    }

    public function getAllByJobNumber ($obra)
    {

        $q = $this->select();
        $q->where("obra = ?", $obra);
        $q->order('dia DESC');
        $q->order('hora DESC');
        return $this->fetchAll($q);
    }
}