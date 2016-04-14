<?php
/**
 * 
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 *
 */
class App_Auxiliar_GetPdf
{

    /**
     * Setter
     * @param string $thePath
     */
    public function setPath ($thePath)
    {

        $this->thePath = $thePath;
    }

    /**
     * Getter
     */
    private function getPath ()
    {

        return $this->thePath;
    }

    /**
     * Cria a select box com todos os Pdfs da directoria
     */
    public function build ()
    {

        if (@$handle = opendir($this->getPath())) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != "..") {
                    $contents[] = $file;
                }
            }
            closedir($handle);
            if (count($contents > 1)) {
                foreach ($contents as $file) {
                    $length = strlen($file);
                    $characters = 4;
                    $start = $length - $characters;
                    $fileExt = substr($file, $start, $characters);
                    if ($fileExt == '.pdf') {
                        echo '<option value="http://intranet.fterceiro.pt' . $this->getPath() . '/' . $file . '">' . $this->shortenText($file) . '</option>';
                    }
                }
            }
        }
    }

    /**
     * Reduz o tamanho do nome do ficheiro para x caracteres
     * 
     * @param string $text
     * @param int $chars
     */
    private function shortenText ($text, $chars = 25)
    {

        $length = strlen($text);
        $text = strip_tags($text);
        $text = substr($text, 0, $chars);
        if ($length > $chars) {
            $text = $text . "...";
        }
        return $text;
    }

    public function countFiles ()
    {

        if (@$hndDir = opendir($this->getPath())) {
            $intCount = 0;
            while (false !== ($strFilename = readdir($hndDir))) {
                if ($strFilename != "." && $strFilename != ".." && substr($strFilename, 0, 1 != "._")) {
                    $intCount ++;
                }
            }
            closedir($hndDir);
        } else {
            $intCount = - 1;
        }
        return $intCount;
    }
}
?>