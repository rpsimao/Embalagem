<?php

/**
 * Classe para efectuar pedidos à tabela ArqChapas da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 17/08/2009
 */
class App_User_Service_Cliche extends App_Master_DB_Embalagem
{

    /**
     * Liga a base de dados
     * @return Zend_DB_Table
     */
    public function __construct ()
    {

        parent::__construct();
        $this->cliche = new ClicheTable();
    }

    public function getLabsName ()
    {

        $sql = $this->cliche->getAdapter()->fetchAll('select distinct laboratorio from cliche group by laboratorio');
        //$result = $this->cliche->fetchAll();
        return $sql;
    }

    public function searchCort ($cort)
    {

        $sql = $this->cliche->getAdapter()->fetchAll('select * from cliche where cortante like "%' . $cort . '%"');
        //$result = $this->cliche->fetchAll();
        return $sql;
    }

    public function getCortantes ($lab)
    {

        $sql = $this->cliche->select('cortante')->where('laboratorio = ?', $lab);
        $row = $this->cliche->fetchAll($sql);
        return $row;
    }

    public function getListOfCortantes ()
    {

        foreach ($this->getLabsName() as $name) {
            $labs[] = $name['laboratorio'];
        }
        $numberOfLabs = count($labs);
        for ($i = 0; $i < $numberOfLabs; $i ++) {
            $cortantes[] = $this->getCortantes($labs[$i]);
        }
        return $cortantes;
    }

    public function getSingleArchive ($codigo)
    {

        $sql = $this->cliche->select()->where('id = ?', $codigo);
        $row = $this->cliche->fetchRow($sql);
        return $row;
    }

    /**
     * Get All values
     * @return array
     */
    public function getAll ()
    {

        $select = $this->cliche->select();
        $select->order('laboratorio ASC');
        return $this->cliche->fetchAll($select);
    }

    public function getAllByCxs ()
    {
}

    /**
     * @param array $values
     * @return void
     */
    public function insert (array $values = array())
    {

        $params = array(
            'laboratorio' => $values[0] , 
            'cortante' => $values[1]);
        $this->cliche->insert($params);
    }

    /**
     * @param array $values
     * @return void
     */
    public function update (array $values = array())
    {

        $params = array(
            'laboratorio' => $values[1] , 
            'cortante' => $values[2]);
            
        $where = $this->cliche->getAdapter()->quoteInto('id = ?', $values[0]);
        $this->cliche->update($params, $where);
    }

    public function delete ($id)
    {

        $where = $this->cliche->getAdapter()->quoteInto('id = ?', $id);
        $this->cliche->delete($where);
    }
}