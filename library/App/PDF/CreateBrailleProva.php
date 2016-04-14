<?php
/**
 * Classe para criar PDF do Braille para prova
 * 
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 10/03/2010
 */
class App_PDF_CreateBrailleProva
{
    
    /**
     * Nome da base PDF para brailles sem fêmea
     * @var string
     */
    const PDF_FILE = 'Template/brailleprova.pdf';
    
    /**
     * Valores para criar os campos do PDF
     * @var array
     */
    protected $values = array();
    
    /**
     * Parametros para partir o texto em várias linhas
     * @var array
     */
    protected $params = array();
    
    /**
     * Load values for PDF
     *
     * @param array $values
     * @return array
     */
    function __construct (array $values = array())
    {
        $this->values = $values;
    }

    /**
     * @abstract Parte o texto a partir de X caracteres
     * @param array $params
     * @return mixed
     */
    private function lineWrap (array $params = array())
    {

        $text = stripcslashes($params['texto_para_partir']);
        $text = wordwrap($text, $params['num_max_palavras'], '\r\n', true);
        $headlineArray = explode('\r\n', $text);
        $startPos = $params['pagina_pdf'];
        foreach ($headlineArray as $line) {
            $line = ltrim($line);
            $params['pagina_pdf']->drawText($line, $params['posicaoX'] + $params['soma'], $startPos - $params['posicaoY'], 'UTF-8');
            $startPos = $startPos - 20;
        }
    }

    /**
     * @abstract Parte o texto do Braille que vem caixa de texto da form
     * @param array $params
     * @return mixed
     */
    private function brailleWrap (array $params = array())
    {

        $text = stripcslashes($params['texto_para_partir']);
        $headlineArray = explode('\r\n', $text);
        $startPos = $params['pagina_pdf'];
        foreach ($headlineArray as $line) {
            $line = ltrim($line);
            $params['pagina_pdf']->drawText($line, $params['posicaoX'], $startPos - $params['posicaoY'], 'UTF-8');
            $startPos = $startPos - 20;
        }
    }

   
    
    /**
     * Gera o PDF
     * @return Zend_Pdf
     */
    public function createPDF ()
    {    
        
        //Extrai a font Braille do documento PDF para gerar os restantes
        $pdf = Zend_Pdf::load(self::PDF_FILE);
        foreach ($pdf->pages as $page) {
            $fontList = $pdf->pages[0]->extractFonts();
            foreach ($fontList as $font) {
                $page = $pdf->pages[0]->setFont($font, 24);
                $braille = $font->getFontName(Zend_Pdf_Font::NAME_POSTSCRIPT, 'pt', 'ISO-8859-1');
            }
            //Parte o texto em parágrafos
            $text = stripcslashes($this->values['texto']);
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            $startPos = 840;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $page = $pdf->pages[0]->drawText($line, 15, $startPos - 50, 'ISO-8859-1');
                $startPos = $startPos - 28.3;
            }
            
            /**
             * Braille com txt em baixo
             */
            $startPos = 500;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $page = $pdf->pages[0]->drawText($line, 15, $startPos - 50, 'ISO-8859-1');
                $startPos = $startPos - 40;
            }
            
            
            
            
            
            
            $page = $pdf->pages[0]->saveGS();
            $page = $pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(16));
            $text = stripcslashes($this->values['texto']);
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            $startPos = 840;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $page = $pdf->pages[0]->drawText($line, 380, $startPos - 50, 'ISO-8859-1');
                $startPos = $startPos - 25;
            }
            
            /**
             * Braille com txt em baixo
             */
            
                    
            $page = $pdf->pages[0]->restoreGS();
            $page = $pdf->pages[0]->saveGS();
            $page = $pdf->pages[0]->setStyle(App_PDF_FontStyles::normalWithCustomColor(8, 0.6, 0.6, 0.6));
            $startPos = 480;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
            
                $chars = str_split($line);
                $i = 15;
            
                foreach ($chars as $char) {
                     
                    $page = $pdf->pages[0]->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                    $i+= 17;
                }
                 
                $startPos = $startPos - 40;
            }
            
            
            
            
            
            
            $startPos = 883;
            $page = $pdf->pages[0]->restoreGS();
            $page = $pdf->pages[0]->saveGS();
            $page = $pdf->pages[0]->setStyle(App_PDF_FontStyles::Bold(16));
            $page = $pdf->pages[0]->drawText('Braille para colocar na caixa', 20, $startPos - 50, 'ISO-8859-1');
            $page = $pdf->pages[0]->restoreGS();
            $startPos = 540;
            $page = $pdf->pages[0]->saveGS();
            $page = $pdf->pages[0]->setStyle(App_PDF_FontStyles::Bold(16));
            $page = $pdf->pages[0]->drawText('Braille para colocar na Prova', 20, $startPos - 50, 'ISO-8859-1');
            $page = $pdf->pages[0]->restoreGS();
           return $pdf;
        }
        
    }
}   