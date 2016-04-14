<?php
/**
 * Classe para criar PDF do Braille
 * 
 * 
 * @author Ricardo Simao
 * @version 1.5
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 17/08/2009
 */
class App_PDF_Create
{
    
    
    /**
     * Nome da base PDF para brailles sem fÃªmea
     * @var string
     */
    const PDF_FILE = 'Template/braille.pdf';
    
    /**
     * Nome da base PDF para brailles com fÃªmea
     * @var string
     */
    const PDF_FILE_FEMEA = 'Template/braille_femea.pdf';
    
    /**
     * Valores para criar os campos do PDF
     * @var array
     */
    protected $values = array();
    
    /**
     * Parametros para partir o texto em vÃ¡rias linhas
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
     * @abstract Conforme o valor (boolean) escreve um X como caixa assinalada
     * @param integer $value
     * @return string
     *
     */
    private function checkBoxes ($value)
    {

        $xMarkTheSpot = ($value == 1) ? 'X' : '';
        return $xMarkTheSpot;
    }

   
    /**
     * @abstract Consoante o nÃºmero de linhas da fÃªmea, define o offset onde irÃ¡ aparecer no PDF
     * @param integer $size
     * @return int
     */
    private function femeaOffset ($size)
    {

        switch ($size) {
            case 0:
                return 340;
                break;
            case 1:
                return 310;
                break;
            case 2:
                return 280;
                break;
            case 3:
                return 250;
                break;
            case 4:
                return 220;
                break;
            case 5:
                return 190;
                break;
            case 6:
                return 160;
                break;
            case 7:
                return 140;
                break;
            case 8:
                return 120;
                break;
            case 9:
                return 100;
                break;
            case 10:
                return 80;
                break;
                
            
        }
    }
    
    /**
     * Gera o PDF
     * @return Zend_Pdf
     */
    public function getPDF ()
    {    
        
        $femea = new App_Calculations_FemaleBraille($this->values['largura'], $this->values['altura']);
        //Extrai a font Braille do documento PDF para gerar os restantes
        $pdf = ($this->values['femea'] == 1) ? Zend_Pdf::load(self::PDF_FILE_FEMEA) : Zend_Pdf::load(self::PDF_FILE);

            $fontList = $pdf->pages[0]->extractFonts();
            foreach ($fontList as $font) {
                $pdf->pages[0]->setFont($font, 24);
                $font->getFontName(Zend_Pdf_Font::NAME_POSTSCRIPT, 'pt', 'ISO-8859-1');
            }
            //Parte o texto em parÃ¡grafos
            $text = stripcslashes($this->values['texto']);
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            $startPos = 860;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $pdf->pages[0]->drawText($line, 80, $startPos - 200, 'ISO-8859-1');
                $startPos = $startPos - 35;
            }
            //Dependente do tipo de cortante desenha a fêmea
            if ($this->values['femea'] == 1) {
                $leading = 0;
                if ($this->values['cortante'] == 0)
                    for ($i = 1; $i <= $femea->calculateForCAHeight(); $i ++) {
                        $pdf->pages[0]->drawText(str_repeat('é', $femea->calculateForCALenght()), 70, $this->femeaOffset($femea->calculateForCAHeight()) + $leading, 'ISO-8859-1');
                        $leading += 28.3;
                    }
                else {
                    for ($i = 1; $i <= $femea->calculateForCCHeight(); $i ++) {
                        $pdf->pages[0]->drawText(str_repeat('é', $femea->calculateForCCLenght()), 70, $this->femeaOffset($femea->calculateForCCHeight()) + $leading, 'ISO-8859-1');
                        $leading += 28.3;
                    }
                }
            }
            $pdf->pages[0]->saveGS();
	        $pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(12));
            $text = stripcslashes($this->values['texto']);
            $headlineArray = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);
            
            
            $startPos = ($this->values['femea'] == 1) ? 720 : 600;
            
            
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
                $pdf->pages[0]->drawText($line, 80, $startPos - 200, 'ISO-8859-1');
                $startPos = $startPos - 15;
            }
            
            $pdf->pages[0]->restoreGS();
            $pdf->pages[0]->saveGS();
            $pdf->pages[0]->setStyle(App_PDF_FontStyles::normalWithCustomColor(8,0.60,0.60,0.60));
            $startPos = 695;
            foreach ($headlineArray as $line) {
                $line = preg_replace('/\r/', '', $line);
            
                $chars = str_split($line);
                $i = 80;
            
                foreach ($chars as $char) {
                     
                    $pdf->pages[0]->drawText($char, $i, $startPos - 44, 'ISO-8859-1');
                    $i+= 17.2;
                }
                 
                $startPos = $startPos - 36;
            }
            
            
            
            $pdf->pages[0]->restoreGS();
            $jobData = new App_User_Service_Optimus();
            $jobInfo = $jobData->getJobData($this->values['obra']);
            $cortante = $jobData->getJobComments($this->values['obra']);
            $precos = new App_User_Service_BrailleValue();
            $precoFinal = $precos->getAll($this->values['obra']);
            
            $pdf->pages[0]->saveGS();
            $pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(10));
            $pdf->pages[0]->drawText($this->values['obra'], 490, 825, 'ISO-8859-1');
            //$page = $pdf->pages[0]->drawText($jobInfo['j_customer'], 81, 742, 'ISO-8859-1');
            $pdf->pages[0]->drawText($jobInfo['j_title1'], 115, 780, 'ISO-8859-1');
            $pdf->pages[0]->drawText($jobInfo['j_title2'], 170, 765, 'ISO-8859-1');
            $pdf->pages[0]->drawText($cortante['subject'], 153, 750, 'ISO-8859-1');
            $pdf->pages[0]->drawText(number_format($precoFinal['preco_macho'],2), 520, 805, 'ISO-8859-1');
            //if ($precoFinal['preco_femea'] > 0){
            $pdf->pages[0]->restoreGS();
            $pdf->pages[0]->saveGS();
            $pdf->pages[0]->setStyle(App_PDF_FontStyles::bold(9));
            $pdf->pages[0]->drawText('UNIDADES: '. (int)($this->values['numpecas']) , 450, 785, 'ISO-8859-1');
            $pdf->pages[0]->restoreGS();
            $pdf->pages[0]->saveGS();
            $pdf->pages[0]->setStyle(App_PDF_FontStyles::normal(10));
            //} 
            if ($this->values['femea'] == 1) {
                if ($this->values['cortante'] == 0) {
                    $pdf->pages[0]->saveGS();
                    $pdf->pages[0]->rotate(49, 258, M_PI / 2);
                    $pdf->pages[0]->drawText($femea->calculateForCAHeight(), 20, 272, 'ISO-8859-1');
                    $pdf->pages[0]->restoreGS();
                    $pdf->pages[0]->drawText($femea->calculateForCALenght(), 280, 358, 'ISO-8859-1');
                } else {
                    $pdf->pages[0]->saveGS();
                    $pdf->pages[0]->rotate(49, 258, M_PI / 2);
                    $pdf->pages[0]->drawText($femea->calculateForCCHeight(), 20, 272, 'ISO-8859-1');
                    $pdf->pages[0]->restoreGS();
                    $pdf->pages[0]->drawText($femea->calculateForCCLenght(), 280, 358, 'ISO-8859-1');
                }
            } /*else {
                $page = $pdf->pages[0]->saveGS();
                $page = $pdf->pages[0]->setStyle(App_PDF_FontStyles::bold(16));
                $page = $pdf->pages[0]->drawText('Não é necessário.', 180, 370, 'ISO-8859-1');
                $page = $pdf->pages[0]->restoreGS();
            }*/
            $pdf->pages[0]->restoreGS();
            return $pdf;

    }
}