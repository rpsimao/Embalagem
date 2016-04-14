<?php

/** 
 * @author rpsimao
 * 
 */
class App_PDF_SeloBraille
{
    const CONDENSED      = 'fonts/Arial_Narrow.ttf';
    const CONDENSED_BOLD = 'fonts/Arial_Narrow_Bold.ttf';
    
    const PDF_FILE = 'Template/rotulo_braille.pdf';
    
    
    const BRAILLE_FONT = "fonts/Braille_Type.ttf";
    
    
    private $properties = array();
    
    
    protected $styles;
    
    public function __construct()
    {
        $this->styles = new App_PDF_FontStyles();
    }
    
    public function setRep(array $values = array())
    {
        $this->reps = $values;
    }
    
    
    private function _getReps()
    {
        return $this->reps;
    }
    
    
    
    public function __set($prop, $value) {
        $this->properties[$prop] = $value;
    }
    
    public function __get($prop) {
        return $this->properties[$prop];
    }
    
    private function _condensed($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED), $fontSize);
        return $style;
    }
    
    private function _condensedBold($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED_BOLD), $fontSize);
        return $style;
    }
    
    
    
    private function _braille($fontSize)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::BRAILLE_FONT), $fontSize);
        return $style;
    }
    
    private function _normalWithCustomColor ($fontSize, $red, $green, $blue)
    {
        $style = new Zend_Pdf_Style();
        $style->setFillColor(new Zend_Pdf_Color_Rgb($red, $green, $blue));
        $style->setFont(Zend_Pdf_Font::fontWithPath(self::CONDENSED), $fontSize);
        return $style;
    }
    
    
    
    
    
    
    public function buildPDF()
    {

        
        $pdf = Zend_Pdf::load(self::PDF_FILE);
        
        foreach ($pdf->pages as $page)
        {
            
            
            $fontList = $pdf->pages[0]->extractFonts();
            foreach ($fontList as $font) {
                $page = $pdf->pages[0]->setFont($font, 24);
                $braille = $font->getFontName(Zend_Pdf_Font::NAME_POSTSCRIPT, 'pt', 'ISO-8859-1');
            }
            //Parte o texto em parágrafos
            $text = stripcslashes(utf8_decode($this->txtbraille));
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            $howmanylines = count($headlineArray);
            $startPos = 220;
            
            if ($howmanylines <= 4) {
            
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $page = $pdf->pages[0]->drawText($line, 45, $startPos - 50, 'ISO-8859-1');
                $startPos = $startPos - 35;
            }
            /**
             * Braille com txt em baixo
             */
            $page = $pdf->pages[0]->saveGS();
            $page = $pdf->pages[0]->setStyle($this->_normalWithCustomColor(8, 0.6, 0.6, 0.6));
            $startPos = 205;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
            
                $chars = str_split($line);
                $i = 45;
            
                foreach ($chars as $char) {
                     
                    $page = $pdf->pages[0]->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                    $i+= 17;
                }
                 
                $startPos = $startPos - 35;
            }
            $page->restoreGS();
            } else if ($howmanylines == 5){
                
                foreach ($fontList as $font) {
                    $page = $pdf->pages[0]->setFont($font, 18);
                    $braille = $font->getFontName(Zend_Pdf_Font::NAME_POSTSCRIPT, 'pt', 'ISO-8859-1');
                }
                
                foreach ($headlineArray as $line) {
                    $line = preg_replace('/\r/', '', $line);
                    $page = $pdf->pages[0]->drawText($line, 45, $startPos - 50, 'ISO-8859-1');
                    $startPos = $startPos - 27;
                }
                /**
                 * Braille com txt em baixo
                 */
                $page = $pdf->pages[0]->saveGS();
                $page = $pdf->pages[0]->setStyle($this->_normalWithCustomColor(8, 0.6, 0.6, 0.6));
                $startPos = 205;
                foreach ($headlineArray as $line) {
                    $line = preg_replace('/\r/', '', $line);
                
                    $chars = str_split($line);
                    $i = 45;
                
                    foreach ($chars as $char) {
                         
                        $page = $pdf->pages[0]->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                        $i+= 12.75;
                    }
                     
                    $startPos = $startPos - 27;
                }
                $page->restoreGS();
                
            } else if ($howmanylines >= 6){
                $startPos = 233;
                foreach ($fontList as $font) {
                    $page = $pdf->pages[0]->setFont($font, 16);
                    $braille = $font->getFontName(Zend_Pdf_Font::NAME_POSTSCRIPT, 'pt', 'ISO-8859-1');
                }
                
                foreach ($headlineArray as $line) {
                    $line = preg_replace('/\r/', '', $line);
                    $page = $pdf->pages[0]->drawText($line, 45, $startPos - 50, 'ISO-8859-1');
                    $startPos = $startPos - 20;
                }
                /**
                 * Braille com txt em baixo
                 */
                $page = $pdf->pages[0]->saveGS();
                $page = $pdf->pages[0]->setStyle($this->_normalWithCustomColor(8, 0.6, 0.6, 0.6));
                $startPos = 221;
                foreach ($headlineArray as $line) {
                    $line = preg_replace('/\r/', '', $line);
                
                    $chars = str_split($line);
                    $i = 45;
                
                    foreach ($chars as $char) {
                         
                        $page = $pdf->pages[0]->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                        $i+= 11.333;
                    }
                     
                    $startPos = $startPos - 20;
                }
                $page->restoreGS();
                
                
            }
            /*try {
                
                $image = Zend_Pdf_Image::imageWithPath($this->file);
                $page->drawImage($image, $this->width, 0, 0, $this->height);
                
            } catch (Exception $e) {
                $page->saveGS();
                $page->setStyle($this->_condensed(8));
                $page->drawText($this->file, 30, 500, 'UTF-8');
                $page->restoreGS();
            }*/
            
            $page->saveGS();
            $page->setStyle($this->_condensed(8));
            $page->drawText($this->nbraille_lab, 68, 313, 'UTF-8');
            $page->drawText($this->nbraille_shortlab."-", 292, 313, 'UTF-8');
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle($this->styles->bold(9));
            $page->drawText(App_Auxiliar_AddZero::num($this->nbraille_num), 309.5, 313, 'UTF-8');
            $page->restoreGS();
            $page->saveGS();
            $page->setStyle($this->_condensed(8));
            $page->drawText('-'.App_Auxiliar_AddZero::month($this->nbraille_mes)."-".App_Auxiliar_AddZero::month($this->nbraille_ano), 336, 313, 'UTF-8');
            $page->drawText($this->produto, 72, 300, 'UTF-8');
            $page->drawText($this->codf3, 66, 287.5, 'UTF-8');
            $page->drawText($this->codcli, 73, 274.5, 'UTF-8');
            $page->drawText($this->verify, 125, 262.5, 'UTF-8');
            $page->drawText(App_Auxiliar_AddZero::month($this->nbraille_mes) . "/" . App_Auxiliar_AddZero::ISOYear($this->nbraille_ano) , 308, 262.5, 'UTF-8');
            $page->drawText($this->obras, 103, 250.5, 'UTF-8');
            
            if ($this->b1 > 0) {
                $page->drawText("X", 40.5, 237, 'UTF-8');
                $page->drawText($this->b1, 115, 238, 'UTF-8');
            }
            
            if ($this->b2 > 0) {
                $page->drawText("X", 40.5, 224, 'UTF-8');
                $page->drawText($this->b2, 115, 225, 'UTF-8');
            }
            
            if ($this->b3 > 0) {
                $page->drawText("X", 234, 237, 'UTF-8');
                $page->drawText($this->b3, 309, 238, 'UTF-8');
            }
            
            if ($this->b4 > 0) {
                $page->drawText("X", 234, 224, 'UTF-8');
                $page->drawText($this->b4, 309, 225, 'UTF-8');
            }
            
            
            
            $page->drawText($this->obs, 105, 210, 'UTF-8');
            
            $page->restoreGS();
            
            
            /**
             *     REPETIÇÕES
             */
            $startPos = 347;
            $i = 250;
            $page->saveGS();
            $page->setStyle($this->_condensed(7));
            
            foreach ($this->_getReps() as $repeticao) {

                $date3 = date('d-m-Y', strtotime($repeticao['data']));
                $txt = "Rep. de " . $repeticao["pecas"] . " peças em " .$date3;
                $page->drawText($txt, $i, $startPos - 44, 'UTF-8');
                $startPos -= 7;
            }
             
            
            $page->restoreGS();
            
            
            
            
            /*$page->saveGS();
            $page->setStyle($this->_braille(24));
            $text = stripcslashes(utf8_decode($this->txtbraille));
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            $startPos = 220;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $page = $page->drawText($line, 41, $startPos - 50, 'ISO-8859-1');
                $startPos = $startPos - 35;
            }
              }
              $page->restoreGS();
            
            $page->saveGS();
            $page->setStyle($this->_normalWithCustomColor(8, 0.6, 0.6, 0.6));
            $startPos = 205;
            $text = stripcslashes(utf8_decode($this->txtbraille));
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
            
                $chars = str_split($line);
                $i = (preg_match('/[A-Z]$/',$chars[0])==true)  ? 55 : 41;
               
            
                foreach ($chars as $char) {
                     
                    $page = $page->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                    $i+= 15.3;
                }
                 
                $startPos = $startPos - 35;
            }
            $page->restoreGS();
        */
        }  
        return $pdf;
    } 
        
}

