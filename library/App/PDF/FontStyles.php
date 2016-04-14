<?php
/**
 * Classe genérica para definição de estilos de fontes para o texto dos PDFs
 * 
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_PDF_FontStyles
{
    /**
     * Caminho para fonte condensada
     * @var string
     */
    const CONDENSED = 'fonts/Arial_Narrow.ttf';
    
    /**
     * Caminho para fonte condensada bold
     * @var string
     */
    const CONDENSED_BOLD = 'fonts/Arial_Narrow_Bold.ttf';
    
    /**
     * Tamanho do corpo da fonte
     * @var int
     */
    protected $fontSize;
    
    /**
     * Valor da tinta RED
     * @var float
     */
    protected $red;
    
    /**
     * valor da tinta GREEN
     * @var float
     */
    protected $green;
    
    /**
     * Valor da tinta BLUE
     * @var float
     */
    protected $blue;
    
    /**
     * Número para converter para currency local
     * @var int
     */
    protected $number;
    
    /**
     * Define o estilo da fonte
     * @var Zend_Pdf_Style
     */
    protected $style;
    
    /**
     * Fonte Euro
     * @param int $fontSize
     * @return Zend_Pdf_Style
     */
    public static function euro ($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Helvetica Normal
     * @param int $fontSize
     * @return Zend_Pdf_Style
     */
    public static function normal ($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Helvetica Normal
     * @param int $fontSize
     * @param float $width
     * @return Zend_Pdf_Style
     */
    public static function normalWidth ($fontSize, $width)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setLineWidth($width);
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Helvetica Bold
     * @param int $fontSize
     * @return Zend_Pdf_Style
     */
    public static function bold ($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Condensada
     * @param int $fontSize
     * @return Zend_Pdf_Style
     */
    public static function condensed ($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Condensed Bold
     * @param int $fontSize
     * @return Zend_Pdf_Style
     */
    public static function condensedBold ($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED_BOLD), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Helvetica Normal com hipotese de escolher a cor
     * @param int $fontSize
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return Zend_Pdf_Style
     */
    public static function normalWithCustomColor ($fontSize, $red, $green, $blue)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Helvetica Bold com hipotese de escolher a cor
     * @param int $fontSize
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return Zend_Pdf_Style
     */
    public static function boldWithCustomColor ($fontSize, $red, $green, $blue)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
        $style->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), $fontSize);
        return $style;
    }
    
    /**
     * Fonte Condensed com hipotese de escolher a cor
     * @param int $fontSize
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return Zend_Pdf_Style
     */
    public static function condensedWithCustomColor ($fontSize, $red, $green, $blue)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED), $fontSize);
        return $style;
    }
     
     /**
     * Fonte Condensed Bold com hipotese de escolher a cor
     * @param int $fontSize
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return Zend_Pdf_Style
     */
    public static function condensedBoldWithCustomColor ($fontSize, $red, $green, $blue)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED_BOLD), $fontSize);
        return $style;
    }
    
    /**
     * Pinta um elemento de branco
     * @return Zend_Pdf_Style
     */
    public static function fillWhite ()
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(1, 0, 0));
        return $style;
    }

    
    /**
     * Converte um valor para a currency PT
     * @param int $number
     * @return int
     */
    public static function convertMoney ($number)
    {
        setlocale(LC_MONETARY, 'pt_PT');
        $millhar = number_format($number, 0, ',', '.');
        return $millhar;
    }
}
?>