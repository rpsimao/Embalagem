<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 07/04/15
 * Time: 15:27
 */

class GeneralConfig extends Zend_Db_Table_Abstract {


	/**
	 * @return array
	 */
	public function getAll ()
	{
		$sql  = $this->select();
		$rows = $this->fetchAll($sql);
		return $rows->toArray();
	}

	/**
	 * @param int $id
	 * @return array
	 */
	public function findById ($id)
	{
		$sql = $this->select();
		$sql->where('id = ?', (int) $id);
		$row = $this->fetchRow($sql);

		return $row->toArray();
	}


	/**
	 * Update function, the $values must be defined as field_name => value
	 * @param array $id
	 * @param array $values
	 * @return string
	 */
	public function updateRecord($id, $values = array())
	{

		try {
			$where = $this->getAdapter()->quoteInto('id = ?', (int)$id);


			$this->update($values, $where);

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

	/**
	 * @param int $id
	 */
	public function deleteRecord($id)
	{

		$where = $this->getAdapter()->quoteInto('id = ?', (int) $id);
		$this->delete($where);
	}


}