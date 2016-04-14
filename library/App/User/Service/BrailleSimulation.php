<?php

/**
 * Classe para efectuar pedidos à tabela braille da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 01/07/2014
 */
class App_User_Service_BrailleSimulation extends App_Master_DB_Embalagem
{

    /**
     * Tabela braille
     * @var Zend_Db_Table
     */
    protected $braille;

    /**
     * Largura da caixa
     * @var float
     */
    protected $largura;
    /**
     * Altura da caixa
     * @var float
     */
    protected $altura;

    /**
     * Texto do braille
     * @var string
     */
    protected $text;
    
    /**
     * 
     * Preço do Braille Macho
     * @var float
     */
    protected $malePrice;


	function __construct ()
    {
        parent::__construct();
        $this->braille   = new BrailleSimulationTable();
        $this->malePrice = new BrailleMalePrice();
    }

    /**
     * Insere valores do Braille na base de dados
     * @param float $largura
     * @param float $altura
     * @param int $unidades
     * @param string $texto
     * @param string $token
     * @return void
     */
    public function insert($unidades, $texto, $token)
    {

       $params = array("unidades" => $unidades, 'texto' => $texto, 'token' => $token);
       $this->braille->insert($params);

    }

	/**
	 * @param $token
	 * @return null|Zend_Db_Table_Row_Abstract
	 */
	public function getAll($token)
    {

	    $sql = $this->braille->select()->where('token = ?', $token);
	    $row = $this->braille->fetchRow($sql);
	    return $row;
    }

    /**
     * Retorna o preço corrente do Braille Macho por cm2
     */
    public function getMalePrice()
    {
       $sql = $this->malePrice->find(1)->toArray();
       return number_format($sql[0]['price'],2);
    }

	/**
	 * @param $token
	 */
	public function remove($token)
	{

		$where = $this->braille->getAdapter()->quoteInto('token = ?', $token);
		$this->braille->delete($where);

	}

}