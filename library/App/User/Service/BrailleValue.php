<?php

/**
 * Classe para efectuar pedidos à tabela braille_value da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 18/08/2009
 */
class App_User_Service_BrailleValue extends App_Master_DB_Embalagem
{

    /**
     * Tabela braille
     * @var Zend_Db_Table
     */
    protected $braille;

    /**
     * Número da obra
     * @var int
     */
    protected $obra;

    /**
     * preço do braille macho
     * @var float
     */
    protected $preco_macho;

    /**
     * Preço do braille fêmea
     * @var float
     */
    protected $preco_femea;

    /**
     * Liga à base de dados define a tabela
     * @return Zend_Db_Table
     */
    function __construct ()
    {

        parent::__construct();
        $this->brailleValue = new BrailleValueTable();
    }

    /**
     * Insere os valores
     * @param int $obra
     * @param float $preco_macho
     * @param float $preco_femea
     * @return void
     */
    public function insert ($obra, $preco_macho, $preco_femea)
    {

        try {
            $params = array(
                'obra' => $obra , 
                'preco_macho' => $preco_macho , 
                'preco_femea' => $preco_femea);
            $this->brailleValue->insert($params);
        } catch (Exception $e) {
            $this->update($obra, $preco_macho, $preco_femea);
        }
    }

    /**
     * Actualiza os valores
     * @param int $obra
     * @param float $preco_macho
     * @param float $preco_femea
     * @return void
     */
    public function update ($obra, $preco_macho, $preco_femea)
    {

        $params = array(
            'obra' => $obra , 
            'preco_macho' => $preco_macho , 
            'preco_femea' => $preco_femea);
        $where = $this->brailleValue->getAdapter()->quoteInto('obra = ?', (int) $obra);
        $this->brailleValue->update($params, $where);
    }

    /**
     * Recupera os valores da base de dados consoante o número da obra
     * @param int $obra
     * @return array
     */
    public function getAll ($obra)
    {

        $sql = $this->brailleValue->select()->where('obra = ?',(int) $obra);
        $row = $this->brailleValue->fetchRow($sql);
        return $row;
    }
}