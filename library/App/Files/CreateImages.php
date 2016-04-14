<?php

/**
 * Classe para criar a imagem (thumbnail) da embalagem
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 21/08/2009
 */
class App_Files_CreateImages
{

    /**
     * Caminho onde está o ficheiro
     * @var string
     */
    protected $path;

    /**
     * Caminho final do ficheiro PDF
     * @var string
     */
    protected $srtPDF;

    /**
     * Caminho final do ficheiro jpeg
     * @var string
     */
    protected $output;

    /**
     * Número da obra
     * @var int
     */
    protected $obra;

    /**
     * Define o caminho para o ficheiro
     * @param $path
     * @return string
     */
    public function setPath ($path)
    {

        $this->path = $path;
        return $this;
    }

    /**
     * Define o número da obra
     * @param int $obra
     */
    public function setNumObra ($obra)
    {

        $this->obra = $obra;
    }

    public function getNumObra ()
    {

        return $this->obra;
    }

    public function setCodF3 ($codF3)
    {

        $this->codF3 = $codF3;
    }

    public function getCodF3 ()
    {

        return $this->codF3;
    }

    /**
     * Converte o pdf numa imagem
     * @return void
     */
    public function convert ()
    {

        $strPDF = $this->path . "/temp/preview.pdf";
        $output = $this->path . "/temp/preview.jpg";
        exec("convert \"{$strPDF}\" -colorspace RGB -geometry 230 \"{$output}\"");
        $this->reloadBugLocation();
        unlink($strPDF);
    }

    public function convertFixed ()
    {

        $strPDF = "/media/scope/imagens_ricardo/" . $this->getCodF3() . ".pdf";
        $output = "/media/scope/imagens_ricardo/" . $this->getCodF3() . ".jpg";
        exec("convert \"{$strPDF}\" -colorspace RGB -geometry 230 \"{$output}\"");
        $this->reloadBugLocation();
        @unlink($strPDF);
    }
    
    
    public function convertWithoutRelocation() 
    {
        $strPDF = "/media/scope/imagens_ricardo/" . $this->getCodF3() . ".pdf";
        $output = "/media/scope/imagens_ricardo/" . $this->getCodF3() . ".jpg";
        exec("convert \"{$strPDF}\" -colorspace RGB -geometry 230 \"{$output}\"");
        @unlink($strPDF);
    }

    /**
     * Converte o pdf do cortante numa imagem
     * @return void
     */
    public function convertCort ()
    {

        $cortPDF = $this->path . "/temp/preview_cort.pdf";
        $cortJpg = $this->path . "/temp/preview_cort.jpg";
        exec("convert \"{$cortPDF}\" -colorspace RGB -geometry 550 \"{$cortJpg}\"");
    }

    /**
     * Roda as imagens
     * @param float $degree
     */
    public function rotateImages ($degrees)
    {

        $source = '/media/scope/' . $this->path . "/temp/preview.jpg";
        exec("convert \"{$source}\" -rotate \"$degrees\" \"{$source}\"");
    }

    /**
     * Apaga as imagens
     */
    public function deleteImages ()
    {

        $PDF = $this->path . "/temp/preview.pdf";
        $Jpg = $this->path . "/temp/preview.jpg";
        @unlink($PDF);
        @unlink($Jpg);
    }

    private function reloadBugLocation ()
    {

        header("Location:/cockpit/preview/" . $this->getNumObra());
    }
}
?>