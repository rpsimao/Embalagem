<?php

/**
 * Classe para efectuar pedidos á tabela cartolinas da base de dados embalagem (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_User_Service_Obras extends App_Master_DB_Embalagem
{

    /**
     * incializa a conexão à base de dados
     * @return Zend_Db_Table;
     */
    function __construct ()
    {

        parent::__construct();
        $this->obras = new ObrasTable();
    }

    /**
     * Retira os espaços numa "string"
     * @param string $string
     * @return string
     */
    private function removeSpaces ($string)
    {

        $trimString = str_replace(" ", "", $string);
        return $trimString;
    }

    /**
     * Obtém valores da tabela baseado no número da obra
     * @param int $numObra
     * @return array
     */
    public function getValues ($numObra)
    {

        $sql = $this->obras->select()->where("obra = '$numObra'");
        $row = $this->obras->fetchRow($sql);
        return $row;
    }

    /**
     * Insere os valores na tabela
     * @param int $obra
     * @param string $cliente
     * @param string $produto
     * @param string $formato
     * @param string $edicao
     * @param string $cartolina
     * @param string $espessura
     * @param string $codproduto
     * @param string $codlaetus
     * @param string $codvisual
     * @param string $codf3
     * @param string $numcores
     * @param bollean $vernizmaq
     * @param bollean $vernizuv
     * @param bollean $vernizagua
     * @param bollean $plastificacao
     * @param bollean $estampagem
     * @param bollean $braille
     * @param bollean $picote
     * @param bollean $relevo
     * @param int $prova
     * @return void
     */
    public function insertObra ($obra, $cliente, $produto, $formato, $edicao, $cartolina, $espessura, $codproduto, $codlaetus, $codvisual, $codf3, $numcores, $vernizmaq, $vernizuv, $vernizagua, $plastificacao, $estampagem, $braille, $picote, $relevo, $prova)
    {

        $params = array(
            'obra' => $obra , 
            'cliente' => $cliente , 
            'produto' => $produto , 
            'formato' => $formato , 
            'edicao' => $edicao , 
            'cartolina' => $cartolina , 
            'espessura' => $espessura , 
            'codproduto' => $codproduto , 
            'codlaetus' => $codlaetus , 
            'codvisual' => $codvisual , 
            'codf3' => $codf3 , 
            'numcores' => App_Service_Cleaners_Colors::stringClean($this->removeSpaces($numcores)) , 
            'vernizmaq' => $vernizmaq , 
            'vernizuv' => $vernizuv , 
            'vernizagua' => $vernizagua ,
            'plastificacao' => $plastificacao,
            'estampagem' => $estampagem,     
            'braille' => $braille ,
            'picote' => $picote ,
            'relevo' => $relevo , 
            'prova' => $prova);
        $this->obras->insert($params);
    }

    /**
     * Actualiza os valores na tabela
     * @param int $obra
     * @param string $cliente
     * @param string $produto
     * @param string $formato
     * @param string $edicao
     * @param string $cartolina
     * @param string $espessura
     * @param string $codproduto
     * @param string $codlaetus
     * @param string $codvisual
     * @param string $codf3
     * @param string $numcores
     * @param bollean $vernizmaq
     * @param bollean $vernizuv
     * @param bollean $vernizagua
     * @param bollean $plastificacao
     * @param bollean $estampagem
     * @param bollean $braille
     * @param bollean $picote
     * @param bollean $relevo
     * @param int $prova
     * @return void
     */
    public function updateJob ($obra, $cliente, $produto, $formato, $edicao, $cartolina, $espessura, $codproduto, $codlaetus, $codvisual, $codf3, $numcores, $vernizmaq, $vernizuv, $vernizagua, $plastificacao, $estampagem, $braille, $picote, $relevo, $prova)
    {

        $params = array(
            'obra' => $obra , 
            'cliente' => $cliente , 
            'produto' => $produto , 
            'formato' => $formato , 
            'edicao' => $edicao , 
            'cartolina' => $cartolina , 
            'espessura' => $espessura , 
            'codproduto' => $codproduto , 
            'codlaetus' => $codlaetus , 
            'codvisual' => $codvisual , 
            'codf3' => $codf3 , 
            'numcores' => App_Service_Cleaners_Colors::stringClean($this->removeSpaces($numcores)) , 
            'vernizmaq' => $vernizmaq , 
            'vernizagua' => $vernizagua ,
            'plastificacao' => $plastificacao,
            'estampagem' => $estampagem,
            'vernizuv' => $vernizuv , 
            'braille' => $braille ,
            'picote' => $picote ,
            'relevo' => $relevo, 
            'prova' => $prova);
        $where = $this->obras->getAdapter()->quoteInto('obra = ?', $obra);
        $this->obras->update($params, $where);
    }
}
?>