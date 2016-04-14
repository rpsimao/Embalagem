<?php

/**
 * Classe para calcular a fêmea dos Brailles
 * 
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 30/09/2010
 */
class App_Calculations_FemaleBraille
{

    /**
     * Valor em pontos do espaço horizontal da letra de braille
     * @var int
     */
    const LETTER_WIDTH = 17;

    /**
     * Valor em pontos do espaço vertical da letra de braille
     * @var float
     */
    const LETTER_HEIGHT = 28.4;

    /**
     * Margem de segurança para o cortante cilíndricas
     * @var float
     */
    const CC_MARGIN = 5;

    /**
     * Margem de segurança para o cortante autoplatina
     * @var float
     */
    const CA_MARGIN = 5;

    /**
     * Conversão de pontos para milímetros
     * @var float
     */
    const POINT_TO_MM = 0.352;

    const LINHAS_1 = 4;
    
    const LINHAS_2 = 4;
    
    const LINHAS_3 = 6;
    
    const LINHAS_4 = 9;
    
    const LINHAS_5 = 11;
    
    const LINHAS_6 = 13;
    
    
    /**
     * Valor da medida horizontal
     * @var int
     */
    protected $_x;

    /**
     * Vaor da medida vertical
     * @var int
     */
    protected $_y;
    
    /**
     * Quantidade
     * @var int
     */
    protected $_qtd;
    
    
    /**
     * kerning altura em pontos
     */
    const KERN_ALT = 10.078;
    
    
    /**
     * kerning largura em pontos
     */
    
    const KERN_LRG = 6.234;
    

    /**
     * Inicializa as medidas
     * @param int $_x
     * @param int $_y
     * @param int $_qtd
     * @return mixed
     */
    function __construct ($_x, $_y, $_qtd = null)
    {

        $this->_x   = $_x;
        $this->_y   = $_y;
        $this->_qtd = $_qtd;
    }
 	/**
     * Calcula o quantas linhas de altura tem a fêmea para Autoplatina
     * @return int
     */
    public function calculateForCAHeight ()
    {
        $femeaHeightToPoints = ($this->_y - self::CA_MARGIN - self::CA_MARGIN) / self::POINT_TO_MM;
        $femaleHeight = ($femeaHeightToPoints + self::KERN_ALT) / self::LETTER_HEIGHT;
        return floor($femaleHeight);
        
       // return $femaleHeight;
    }
    
    /**
     * Calcula o quantas linhas de largura tem a fêmea para Autoplatina
     *  @return int
     */
    public function calculateForCALenght ()
    {

        $femeaLenghtToPoints = ($this->_x - self::CA_MARGIN - self::CA_MARGIN) / self::POINT_TO_MM;
        $femaleLenght = ($femeaLenghtToPoints + self::KERN_LRG) / self::LETTER_WIDTH;
        return floor($femaleLenght);
    }
    
    /**
     * Calcula o quantas linhas de altura tem a fêmea para Cilindrica
     * @return int
     */
    public function calculateForCCHeight ()
    {

        $femeaHeightToPoints = ($this->_y - self::CA_MARGIN - self::CA_MARGIN) / self::POINT_TO_MM;
        $femaleHeight = ($femeaHeightToPoints + self::KERN_ALT) / self::LETTER_HEIGHT;
        return floor($femaleHeight);
    }
    
    /**
     * Calcula o quantas linhas de largura tem a fêmea para Cilindrica 
     * @return int
     */
    public function calculateForCCLenght ()
    {

        $femeaLenghtToPoints = ($this->_x - self::CC_MARGIN - self::CC_MARGIN) / self::POINT_TO_MM;
        $femaleLenght = ($femeaLenghtToPoints + self::KERN_LRG)  / self::LETTER_WIDTH;
        return floor($femaleLenght);
    }
    
    
    /**
     * Calcula a altura da caixa
     * @return float
     */
    public function returnCxHeight()
    {
        return ($this->_y - self::CC_MARGIN - self::CC_MARGIN) / 10;
        
    }
    
    
    /**
     * Calcula a largura da caixa
     * @return float
     */
    public function returnCxLenght()
    {
        return ($this->_x - self::CC_MARGIN - self::CC_MARGIN) / 10;
    
    }
    
    
    /**
     * Calcula o valor do preço do Braille Fêmea
     * @param int $qtd
     * @param int $linhas
     */
    
    public function calculatePrecoLinhas($qtd, $linhas)
    {
      $values = array(
                      self::LINHAS_2 => 2,
                      self::LINHAS_3 => 3,
                      self::LINHAS_4 => 4,
                      self::LINHAS_5 => 5,
                      self::LINHAS_6 => 6
                      );
                      
       if ($key = array_search($linhas, $values))
       {
           return $key * $qtd;
       }
       
        
    }
}
?>