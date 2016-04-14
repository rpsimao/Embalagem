<?php

class Arqbrailles extends Zend_Db_Table_Abstract
{

    protected $_name = 'arqbrailles';

    protected $_primary = 'id';

    public function getAll ()
    {
        $sql  = $this->select();
        $rows = $this->fetchAll($sql);
        return $rows;
    }

    public function findById ($id)
    {
        $sql = $this->select();
        $sql->where('nbraille_num = ?', (int) $id);
        $row = $this->fetchRow($sql);
        
        return $row->toArray();
    }
    
    
    public function getLastNumber()
    {
        $sql = $this->select();
        $sql->order('nbraille_num DESC');
        $row = $this->fetchAll($sql);
        
        return $row;
        
    }
    
    
    public function insertData(array $params)
    {
        
        try {
            $this->insert($params);
            
        } catch (Exception $e) {
            
            $where = $this->getAdapter()->quoteInto('nbraille_num = ?', (int)$params['nbraille_num']);
            $this->update($params, $where);
        }
        
    }
    
    
    public function getByJob($job)
    {
        $sql = $this->select();
        $sql->where("obras LIKE '%$job%'");
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
    
    public function getOneJob($job)
    {
        $sql = $this->select();
        $sql->where('obras = ?', $job);
        $rows = $this->fetchRow($sql);
        return $rows;
    }
    
    public function getByBraille($braille)
    {
        $sql = $this->select();
        $sql->where('nbraille_num = ?', $braille);
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
    public function getLabs()
    {
        $sql = $this->select();
        $sql->group(array('nbraille_lab'))->order('nbraille_lab');
        
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
    public function getByLabs($lab) 
    {
        $sql = $this->select();
        $sql->where('nbraille_lab = ?', $lab);
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
    public function getByCodCli($codcli)
    {
        $sql = $this->select();
        $sql->where("codcli LIKE '%$codcli%'");
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
    public function getByCodF3($codf3)
    {
        $sql = $this->select();
        $sql->where("codf3 LIKE '%$codf3%'");
        $rows = $this->fetchAll($sql);
        return $rows;
    }
    
}

