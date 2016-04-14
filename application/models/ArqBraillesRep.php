<?php

/** 
 * @author rpsimao
 * 
 */
class ArqBraillesRep extends Zend_Db_Table_Abstract
{
    protected $_name = 'brailles_rep';

    protected $_primary = 'id';
    
    
    
    public function create(array $data = array())
    {
        $date = array("data" => date('Y-m-d G:i:s'));
        $params = array_merge($data, $date);
        $this->insert($params);
    }
    
    
    public function findPecas($id)
    {
        $sql = $this->select();
        $sql->where('braille_num = ?', (int) $id);
        $sql->where('pecas > 0');
        
        $rows = $this->fetchAll($sql);
        return $rows->toArray();
    }
    
    
    public function sumpecas($id)
    {
       // $sql = $this->select(array(new Zend_Db_Expr('SUM(pecas) AS pecas')))->where("braille_num = ?", $id);
       $sql = $this->select()->from('brailles_rep')->columns('SUM(pecas) AS pecas');
       $rows = $this->fetchRow($sql);
       return $rows->toArray();
    }


	public function updatePecas(array $params = array())
	{
		$where = $this->getAdapter()->quoteInto('id = ?', (int) $params['id']);
		$this->update($params, $where);
	}

	public function deletePecas($id)
	{

		$where = $this->getAdapter()->quoteInto('id = ?', (int) $id);
		$this->delete($where);
	}
    
    
    
}
?>