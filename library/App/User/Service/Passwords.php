<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 18/06/14
 * Time: 16:42
 */

class App_User_Service_Passwords extends App_Master_DB_Passwords
{

	protected $table;

	public function __construct()
	{
		parent::__construct();
		$this->table = new RecordsTable();
	}



	public function check($passwd)
	{
		$sql = $this->table->select()->where("new_password = ?", $passwd);
		$row = $this->table->fetchRow($sql);

		$check = ($row) ? $row->toArray() : false;

		return $check;

	}



} 