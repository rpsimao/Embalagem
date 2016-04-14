<?php

/**
 * Classe para calcular o preço dos Brailles
 * 
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem
 * 
 * Ultima revisao - 08/02/2010
 */
class App_Calculations_BraillePrice
{

    /**
     * Define o preço do braile macho por cm2
     * LINHA 502 do código
     * @var float
     */
    CONST MACHO_PRECO_CM = 0.18;

    /**
     * Valor da Femea de 18 letras 2 linhas de 4/7 mm
     * @var int
     */
    CONST FEMEA_18LETRAS_2LINHAS_4MM = 8.5;

    /**
     * Valor da Femea de 18 letras 3 linhas de 4/7 mm
     * @var float
     */
    CONST FEMEA_18LETRAS_3LINHAS_4MM = 10;

    /**
     * Valor da Femea de 18 letras 4 linhas de 4/7 mm
     * @var float
     */
    CONST FEMEA_18LETRAS_4LINHAS_4MM = 12;

    /**
     * Valor da Femea de 18 letras 5 linhas de 4/7 mm
     * @var int
     */
    CONST FEMEA_18LETRAS_5LINHAS_4MM = 14.5;

    /**
     * Valor da Femea de 9 letras 2 linhas de 4/7 mm
     * @var int
     */
    CONST FEMEA_9LETRAS_2LINHAS_4MM = 7.5;

    /**
     * Valor da Femea de 9 letras 3 linhas de 4/7 mm
     * @var float
     */
    CONST FEMEA_9LETRAS_3LINHAS_4MM = 9;

    /**
     * Valor da Femea de 9 letras 4 linhas de 4/7 mm
     * @var float
     */
    CONST FEMEA_9LETRAS_4LINHAS_4MM = 11;

    /**
     * Valor da Femea de 9 letras 5 linhas de 4/7 mm
     * @var int
     */
    CONST FEMEA_9LETRAS_5LINHAS_4MM = 13.5;

    /**
     * Valor em mm do tamanho vertical de cada letra
     * @var int
     */
    CONST TAMANHO_LETRA_VERTICAL = 10.13;

    /**
     * Valor em mm do tamanho horizontal de cada letra
     * @var int
     */
    CONST TAMANHO_LETRA_HORIZONTAL = 6;

    /**
     * Espaço em mm a subtrair no valor final vertical
     * @var float
     */
    CONST ESPACO_ENTRE_LETRAS_VERTICAL = 3.5;

    /**
     * Espaço em mm a subtrair no valor final horizontal
     * @var float
     */
    CONST ESPACO_ENTRE_LETRAS_HORIZONTAL = 2.2;

    /**
     * Espaço em mm para margem
     * @var int
     */
    CONST ESPACO_MARGEM = 5;

    /**
     * Medida 1 linha em mm
     * @var int
     */
    CONST LINHA_1 = 12;

    /**
     * Medida 2 linhas em mm
     * @var int
     */
    CONST LINHA_2 = 22;

    /**
     * Medida 3 linhas em mm
     * @var int
     */
    CONST LINHA_3 = 32;

    /**
     * Medida 4 linhas em mm
     * @var int
     */
    CONST LINHA_4 = 42;

    /**
     * Medida 5 linhas em mm
     * @var int
     */
    CONST LINHA_5 = 52;

    /**
     * Medida 6 linhas em mm
     * @var int
     */
    CONST LINHA_6 = 62;

    /**
     * Define o número da obra
     * @var int
     */
    protected $numObra;

    /**
     * Define o texto do braille
     * @var string
     */
    protected $texto;

    /**
     * Inicializa as conexões às tabelas
     * @return mixed
     */
    function __construct ()
    {

        $this->optimus = new App_User_Service_Optimus();
    }

    /**
     * Define o número da obra
     * @param int $numObra
     * @return int
     */
    public function setNumObra ($numObra)
    {

        $this->numObra = $numObra;
        return $this;
    }

    /**
     * Retorna o número da obra
     * @return int
     */
    private function getNumObra ()
    {

        $this->setNumObra($this->numObra);
        return $this;
    }

    /**
     * Define o texto do Braille
     * @param string $texto
     * @return string
     */
    public function setTexto ($texto)
    {

        $this->texto = $texto;

    }

    /**
     * Retorna o texto do braille
     * @return string
     */
    private function getTexto ()
    {

        return $this->texto;
    }

    /**
     * Retorna unidades do cortante a partir dos comentarios da obra do optimus
     * @return int
     *
     * Alterado em 24/3/2014 para verificar se a linha dos comentários do Optimus é a do cortante ou outra
     * Se não for passa para a próxima até encontrar a correcta.
     */
    public function getUnidadesDoCortante ()
    {

        /*$sql = $this->optimus->getJobComments($this->numObra);
        $textoBruto = $sql['subject'];
        $textoArray = explode(" ", $textoBruto);
        $value = $textoArray[2];
        $value += 1;
        return $value;*/

        $rows = $this->optimus->getAllJobComments($this->numObra);

        foreach ($rows as $row) {

            $textoArray = explode(" ", $row['subject']);
            rsort($textoArray);

            if ($textoArray[0] == "UNID")
            {
                $value = (int) $textoArray[3];
                $value+= 1;
                return $value;
            }
        }

    }

    /**
     * Verfica se o ultimo caracter da caixa de texto é um "enter"
     * @param $string
     * @return int
     */
    public function checkLastCharOfTextArea ($string)
    {

        $split = str_split($string);
        $count = count($split);
        $count -= 1;
        if ($split[$count] != "\n") {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * Verfica se o penultimo caracter da caixa de texto é um "enter"
     * @param $string
     * @return int
     */
    public function checkSecondLastCharOfTextArea ($string)
    {

        $split = str_split($string);
        $count = count($split);
        $count -= 2;
        if ($split[$count] == "\n") {
            return 0;
        } else {
            return 1;
        }
    }

    /**
     * Recebe o texto como uma string única e parte-o por parágrafos
     * @return array
     */
    public function formatTextforCount ()
    {

        $text = stripcslashes(strtolower($this->texto));
        $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
        return $headlineArray;
    }

    /**
     * Procura qual a maior linha do texto do braille
     * @return int
     */
    public function calculateMaleLenght ()
    {

        $headlineArray = $this->formatTextforCount();
        $ret = array();
        foreach ($headlineArray as $line) {
            $line = strlen($line);
            $ret[] = $line;
        }
        rsort($ret);
        // if (count($ret) >= 1 && count($ret) <= 3) {
        if (count($ret) >= 1) {
            $biggestLine = $ret[0];
            $biggestLine -= 1;
            return $biggestLine;
        } else {
            $biggestLine = $ret[0];
            return $biggestLine;
        }
    }

    /**
     * Identifica qual o primeiro caracter da maior frase do braille
     * @return string
     */
    public function getFirstChar ()
    {

        $base = $this->formatTextforCount();
        $values = array();
        foreach ($base as $data) {
            $tam = strlen($data);
            $values[] = $tam;
        }
        arsort($values);
        $new = array_keys($values);
        $finalValue = $new[0];
        $bigLine = $base[$finalValue];
        $biglineSize = strlen($bigLine);
        $biglineSize -= 1;
        $bigLineToArray = str_split($bigLine);
        return $bigLineToArray[0];
    }

    /**
     * Verifica se a primeira letra dos restantes paragrafos contem caracteres que possam aumentar o tamanho do braille
     * @return float / zero
     */
    public function checkFirstCharOfAllParagraphs ()
    {

        $first = array(
            '_' , 
            '|');
        $headlineArray = $this->formatTextforCount();
        $ret = array();
        $final = array();
        foreach ($headlineArray as $line) {
            $ret[] = $line;
        }
        rsort($ret);
        if (! in_array($first, $ret)) {
            if (! in_array($this->getFirstChar(), $first)) {
                return 0;
            } else {
                return self::ESPACO_ENTRE_LETRAS_HORIZONTAL;
            }
        } else {
            return 0;
        }
    }

    /**
     * Identifica qual o ultimo caracter da maior frase do braille
     * @return string
     */
    public function getLastChar ()
    {

        $base = $this->formatTextforCount();
        $values = array();
        foreach ($base as $data) {
            $tam = strlen($data);
            $values[] = $tam;
        }
        arsort($values);
        $new = array_keys($values);
        $finalValue = $new[0];
        $bigLine = $base[$finalValue];
        $biglineSize = strlen($bigLine);
        $biglineSize -= 1;
        $bigLineToArray = str_split($bigLine);
        return $bigLineToArray[$biglineSize];
    }

    /**
     * 
     * @param string $string
     * @return float
     */
    private function checkFirstLetter ()
    {

        $string = $this->getFirstChar();
        $first = array(
            '_' , 
            '|');
        if (in_array($string[0], $first)) {
            return self::ESPACO_ENTRE_LETRAS_HORIZONTAL;
        } else {
            return 0;
        }
    }

    /**
     * @deprecated
     * @param string $string
     * @return mixed
     */
    private function checkLastLetter ()
    {

        $string = $this->getLastChar();
        $count = count($string);
        $count -= 1;
        $last = array(
            'a' , 
            'b' , 
            'l' , 
            'k' , 
            ',' , 
            ';' , 
            '.');
        if (in_array($string[$count], $last)) {
            return self::ESPACO_ENTRE_LETRAS_HORIZONTAL;
        } else {
            return 0;
        }
    }

    /**
     * hack para retirar a segunda casa decimal sem arrendondar
     * @param float $float
     * @return float
     */
    private function hackFloatNumbers ($float)
    {

        $numberOfCharacters = count_chars($float);
        if ($numberOfCharacters > 1) {
            $clean = explode(".", $float);
            $split = str_split($clean[1]);
            $finalNumber = $clean[0] . "." . $split[0];
            return $finalNumber;
        }
    }

    /**
     * Calcula o número de linhas que o texto tem
     * @return int
     */
    public function calculateMaleHeight ()
    {

        $headlineArray = $this->formatTextforCount();
        $numberOfLines = count($headlineArray);
        return $numberOfLines;
    }
    
    
    /**
     * @since 2013-05-14
     * Calcula o preço final do Braille segundo a tabela do fornecedor
     */
    
    public function finalBraillePrice()
    {
        $maleArray = array(
                4  => 26 ,
                5  => 32 ,
                6  => 38 ,
                7  => 44 ,
                8  => 50 ,
                9  => 56 ,
                10 => 62 ,
                11 => 68 ,
                12 => 74 ,
                13 => 80 ,
                14 => 86 ,
                15 => 92 ,
                16 => 98 ,
                17 => 104 ,
                18 => 110 ,
                19 => 116 ,
                20 => 122 ,
                21 => 128 ,
                22 => 134 ,
                23 => 140 ,
                24 => 146 ,
                25 => 152 ,
                26 => 158 ,
                27 => 164 ,
                28 => 170 ,
                29 => 176 ,
                30 => 182 ,
                31 => 188 ,
                32 => 194
        );
        
        
        $altArray = array(
                1=>12,
                2=>22,
                3=>32,
                4=>42,
                5=>52,
                6=>62
        );
        
        
        
        
        
        $maleLenght = (int)$this->calculateMaleLenght();
        $maleHeight = (int)$this->calculateMaleHeight();
        
        $chars = $maleArray[$maleLenght];
        $lines = $altArray[$maleHeight];
        
        $unidades = (int)$this->getUnidadesDoCortante();
        
        $value = $chars * $lines;
        $value = $value / 100;
        /**
            OLD METHOD FOR MALE PRICE
         */
        //$value = $value * self::MACHO_PRECO_CM;
        
        // NEW METHOD VIA DB PRICE SET BY THE USER IN THE BRAILLE PAGE
        $value = $value * $this->_getMaleCmPriceDB();
        $value = $value * $unidades;
        
        return round($value, 2);
        
        
    }
    
    
    private function _getMaleCmPriceDB()
    {
        
        $db = new App_User_Service_Braille();
        $price = $db->getMalePrice();
        
        return $price;
        
    }
    

    /**
     * Calcula o valor final da largura do Macho
     * @return float
     */
    public function setMaleLenghtFinalValue ()
    {

        
        $first = $this->checkFirstLetter();
       // $last = $this->checkLastLetter();
        $restPara = $this->checkFirstCharOfAllParagraphs();
        $maleLenght = $this->calculateMaleLenght();
        $value = $maleLenght * self::TAMANHO_LETRA_HORIZONTAL;
        $value -= self::ESPACO_ENTRE_LETRAS_HORIZONTAL;
        
        $value -= $first;
        $value += $restPara;
        //$value += self::ESPACO_MARGEM;
        $value = $value / 10;
        //return $this->hackFloatNumbers($value);
        
        return $value;
       
    }

    /**
     * Calcula o valor final da altura do Macho
     * @return float
     */
    public function setMaleHeightFinalValue ()
    {

        $maleHeight = $this->calculateMaleHeight();
        /*$value = ($maleHeight * self::TAMANHO_LETRA_VERTICAL) - self::ESPACO_ENTRE_LETRAS_VERTICAL;
        $value += self::ESPACO_MARGEM;*/
        switch ($maleHeight) {
            case 1:
                $value = self::LINHA_1;
                break;
            case 2:
                $value = self::LINHA_2;
                break;
            case 3:
                $value = self::LINHA_3;
                break;
            case 4:
                $value = self::LINHA_4;
                break;
            case 5:
                $value = self::LINHA_5;
                break;
            case 6:
                $value = self::LINHA_6;
                break;
        }
        $value = $value/ 10;
       return $this->hackFloatNumbers($value);
        
        
    }

	public function simulateMalePrice ()
	{

		$unidadesCortante = intval($this->getUnidadesDoCortante()) + 1;
		$final = $this->setMaleHeightFinalValue() * $this->setMaleLenghtFinalValue() * $unidadesCortante * self::MACHO_PRECO_CM;
		return round($final, 2);


	}


    public function overrideUnidadesCortanteOptimus($un){


        $final = $this->setMaleHeightFinalValue() * $this->setMaleLenghtFinalValue() * $un * self::MACHO_PRECO_CM;
        return round($final, 2);


    }





	/**
     * calcula o preço final do Macho
     * @return float
     */
    public function calculateMalePrice ()
    {

        $unidadesCortante = intval($this->getUnidadesDoCortante()) + 1;
        $final = $this->setMaleHeightFinalValue() * $this->setMaleLenghtFinalValue() * $unidadesCortante * self::MACHO_PRECO_CM;
        return round($final, 2);
        
        
    }

    public function getFemaleSizes ()
    {

        $femea = new App_User_Service_FemeaSize();
        $femeaValues = $femea->getAll($this->numObra);
        return $femeaValues;
    }

    /**
     * Calcula o preço do braile femea
     * @return float
     */
    public function firstFemaleCalculation ()
    {

        $femaleValues = $this->getFemaleSizes();
        $numCortantes = $this->getUnidadesDoCortante();
        if ($femaleValues['horizontal'] <= 18 && $femaleValues['horizontal'] > 9 && $femaleValues['vertical'] <= 5) {
            switch ($femaleValues['vertical']) {
                case 2:
                    return $firstPrice = self::FEMEA_18LETRAS_2LINHAS_4MM * $numCortantes;
                    break;
                case 3:
                    return $firstPrice = self::FEMEA_18LETRAS_3LINHAS_4MM * $numCortantes;
                    break;
                case 4:
                    return $firstPrice = self::FEMEA_18LETRAS_4LINHAS_4MM * $numCortantes;
                    break;
                case 5:
                    return $firstPrice = self::FEMEA_18LETRAS_5LINHAS_4MM * $numCortantes;
                    break;
            }
        }
        if ($femaleValues['horizontal'] <= 18 && $femaleValues['horizontal'] > 9 && $femaleValues['vertical'] > 5) {
            $verticalExcess = $femaleValues['vertical'] - 5;
            if ($verticalExcess == 1) {
                $verticalExcess += 1;
            }
            $secondPrice = self::FEMEA_18LETRAS_5LINHAS_4MM * $numCortantes;
            switch ($verticalExcess) {
                case 2:
                    return $firstPrice = (self::FEMEA_18LETRAS_2LINHAS_4MM * $numCortantes) + $secondPrice;
                    break;
                case 3:
                    return $firstPrice = (self::FEMEA_18LETRAS_3LINHAS_4MM * $numCortantes) + $secondPrice;
                    break;
                case 4:
                    return $firstPrice = (self::FEMEA_18LETRAS_4LINHAS_4MM * $numCortantes) + $secondPrice;
                    break;
                case 5:
                    return $firstPrice = (self::FEMEA_18LETRAS_5LINHAS_4MM * $numCortantes) + $secondPrice;
                    break;
            }
        }
        if ($femaleValues['horizontal'] <= 9 && $femaleValues['vertical'] <= 5) {
            switch ($femaleValues['vertical']) {
                case 2:
                    return $firstPrice = self::FEMEA_9LETRAS_2LINHAS_4MM * $numCortantes;
                    break;
                case 3:
                    return $firstPrice = self::FEMEA_9LETRAS_3LINHAS_4MM * $numCortantes;
                    break;
                case 4:
                    return $firstPrice = self::FEMEA_9LETRAS_4LINHAS_4MM * $numCortantes;
                    break;
                case 5:
                    return $firstPrice = self::FEMEA_9LETRAS_5LINHAS_4MM * $numCortantes;
                    break;
            }
        }
        if ($femaleValues['horizontal'] > 18 && $femaleValues['vertical'] > 5) {
            $firstPrice = self::FEMEA_18LETRAS_5LINHAS_4MM * $numCortantes;
            $excessoHorizontal = $femaleValues['horizontal'] - 18;
            if ($excessoHorizontal == 1) {
                $excessoHorizontal += 1;
            }
            $excessoVertical = $femaleValues['vertical'] - 5;
            if ($excessoVertical == 1) {
                $excessoVertical += 1;
            }
            if ($excessoHorizontal <= 9 && $excessoVertical <= 5) {
                switch ($excessoVertical) {
                    case 2:
                        return $secondPrice = (self::FEMEA_9LETRAS_2LINHAS_4MM * $numCortantes) + $firstPrice;
                        break;
                    case 3:
                        return $secondPrice = (self::FEMEA_9LETRAS_3LINHAS_4MM * $numCortantes) + $firstPrice;
                        break;
                    case 4:
                        return $secondPrice = (self::FEMEA_9LETRAS_4LINHAS_4MM * $numCortantes) + $firstPrice;
                        break;
                    case 5:
                        return $secondPrice = (self::FEMEA_9LETRAS_5LINHAS_4MM * $numCortantes) + $firstPrice;
                        break;
                }
            }
        }
    }
}
?>