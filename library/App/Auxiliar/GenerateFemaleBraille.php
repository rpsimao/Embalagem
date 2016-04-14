<?php
/**
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 *
 */
class App_Auxiliar_GenerateFemaleBraille
{
    /**
     * 
     * @var string
     */
    protected $altura;
    /**
     * 
     * @var string
     */
    protected $largura;
    /**
     * 
     * @var string
     */
    protected $tipo;
    /**
     * 
     * @var string
     */
    protected $qtd;
    
    
    /**
     * 
     * @param string $altura
     * @param string $largura
     * @param string $tipo
     * @param string $qtd
     */
    function __construct ($altura, $largura, $tipo, $qtd)
    {

        $this->altura = $altura;
        $this->largura = $largura;
        $this->tipo = $tipo;
        $this->qtd = $qtd;
        $this->braille = new App_Calculations_FemaleBraille($this->largura, $this->altura, $this->qtd);
    }

    public function create ()
    {

        if ($this->tipo == 0) //Autoplatina
        {
            $altura     = $this->braille->calculateForCAHeight();
            $largura    = $this->braille->calculateForCALenght();
            $preco      = $this->braille->calculatePrecoLinhas($this->qtd, $altura);
            $qtd        = $this->qtd;
            return array(
                $altura , 
                $largura,
                $preco,
                $qtd);
        } else {
            $altura  = $this->braille->calculateForCCHeight();
            $largura = $this->braille->calculateForCCLenght();
            $preco   = $this->braille->calculatePrecoLinhas($this->qtd, $altura);
            $qtd     = $this->qtd;
            return array(
                $altura , 
                $largura,
                $preco,
                $qtd);
        }
    }
}