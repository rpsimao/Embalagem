<?php

class ArqbraillesLabsTable extends Zend_Db_Table_Abstract
{

    protected $_name = 'arqbrailles_labs';

    protected $_primary = 'id';


	public function insertData (array $params)
    {

        $data = array(
            'optimus'   => strtoupper($params['optimus']) , 
            'shortname' => strtoupper($params['shortname'])
        );
        
        $this->insert($data);
    }

    public function searchCustomer ($customer)
    {

        $emb = new Zend_Validate_Db_NoRecordExists(array(
                'table'   => 'arqbrailles_labs' , 
                'field'   => 'optimus' , 
                'adapter' => self::$_defaultDb));
        $emblab = $emb->isValid($customer);
        
        
        if ($emblab == false) {

            $s = $this->getCliente($customer);
            return $s['shortname'];
        }
        
        return false;
    }

    public function getCliente($cliente)
    {
        $sql = $this->select();
        $sql->where('optimus = ?', $cliente);
        
        $row = $this->fetchRow($sql)->toArray();
        
        return $row;
    }
    
    public function reverseClient($lab)
    {
        $sql = $this->select();
        $sql->where('shortname = ?', $lab);
        
        $row = $this->fetchRow($sql)->toArray();
        
        return $row['optimus'];
    }


	public function listLabs()
	{
		$sql = $this->select()->order("OPTIMUS ASC");
		$rows = $this->fetchAll($sql)->toArray();

		return $rows;


	}

	/**
	 * @param $id int
	 * @param $optimus string
	 * @param $shortname string
	 */
	public function updateLabs($id, $optimus, $shortname)
	{

		try {
			$where = $this->getAdapter()->quoteInto('id = ?', (int)$id);

			$value = array(
				'optimus'   => $optimus,
				'shortname' => $shortname
			);
			$this->update($value, $where);

			return TRUE;
		}
		catch (Exception $exception)
		{
			switch (get_class($exception)){

				case 'Zend_Argument_Exception':
					$message = 'Argument error.';
					break;
				case 'Zend_Db_Statement_Exception':
					$message = 'Database error.';
					break;
				default:
					$message = 'Unknown error.';

			}
			return $message;
		}

	}

	public function deleteLabs($id)
	{

		$where = $this->getAdapter()->quoteInto('id = ?', (int) $id);
		$this->delete($where);
	}

    
}