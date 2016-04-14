<?php

/**
 * Classe para efectuar pedidos à tabela braille da embalagem databse (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 17/08/2009
 */
class App_User_Service_Braille extends App_Master_DB_Embalagem
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
     * Se é necessário fêmea ou não
     * @var boolean
     */
    protected $femea;
    /**
     * Tipo de cortante Autoplatina/Cilindrica
     * @var int
     */
    protected $tipo;
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

    /**
     * Liga à base de dados define a tabela
     * @return Zend_Db_Table
     */
    function __construct ()
    {
        parent::__construct();
        $this->braille = new BrailleTable();
        $this->malePrice = new BrailleMalePrice();
    }

    /**
     * Insere valores do Braille na base de dados
     * @param int $obra
     * @param float $largura
     * @param float $altura
     * @param boolean $femea
     * @param string $tipo
     * @param string $texto
     * @return void
     */
    public function insert ($obra, $largura, $altura, $femea, $tipo, $texto)
    {

        try {
            $params = array(
                'obra' => $obra , 
                'largura' => $largura , 
                'altura' => $altura , 
                'femea' => $femea , 
                'tipo' => $tipo , 
                'texto' => $texto);
            $this->braille->insert($params);
        } catch (Exception $e) {
            $this->update($obra, $largura, $altura, $femea, $tipo, $texto);
        }
    }

    /**
     * Insere valores do Braille na base de dados
     * @param int $obra
     * @param float $largura
     * @param float $altura
     * @param boolean $femea
     * @param string $tipo
     * @param string $texto
     * @return void
     */
    public function update ($obra, $largura, $altura, $femea, $tipo, $texto)
    {

        $params = array(
            'obra'    => $obra , 
            'largura' => $largura , 
            'altura'  => $altura , 
            'femea'   => $femea , 
            'tipo'    => $tipo , 
            'texto'   => $texto);
        $where = $this->braille->getAdapter()->quoteInto('obra = ?',(int) $obra);
        $this->braille->update($params, $where);
    }
    /**
     * Recupera os valores da base de dados consoante o número da obra
     * @param int $obra
     * @return array
     */
    public function getAll($obra)
    {

        $sql = $this->braille->select()->where('obra = ?',(int) $obra);
        $row = $this->braille->fetchRow($sql);
        return $row;
    }

    /**
     * @param string $txt
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function searchTxt($txt)
    {
        $sql = $this->braille->select();
        $sql->where("texto LIKE '%$txt%'");
        $rows = $this->braille->fetchAll($sql);
        
        return $rows;
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
     * Actualiza o preço do Braille macho
     * @param float $price
     */
    public function updateMalePrice($price)
    {
        $params = array('price' => $price );
        $where = $this->malePrice->getAdapter()->quoteInto('id = ?', 1);
        $this->malePrice->update($params, $where);
    }
}