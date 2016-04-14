<?php
/**
 * Classe que define manipulação das imagens
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 */

abstract class App_Abstract_Images implements App_Interfaces_ImagesConvert
{

    protected $thePath;

    protected $size;

    protected $imagePath;

    /**
     * Define o caminho para o ficheiro a ser convertido
     * @param string $thePath
     */
    public function setPath ($thePath)
    {

        $this->thePath = $thePath;
    }

    /**
     * Retorna o caminho para o ficheiro a ser convertido
     */
    public function getPath ()
    {

        return $this->thePath;
    }

    /**
     * Define o tamanho da imagem em pixels
     * 230pixels por defeito
     * @param int $size
     */
    public function setSize ($size = 230)
    {

        $this->size = $size;
    }

    /**
     * retorna o tamanho da imagem
     */
    public function getSize ()
    {

        return $this->size;
    }

    /**
     * Define o caminho para a imagem convertida
     * @param string $imagePath
     */
    public function setImagePath ($imagePath)
    {

        $this->imagePath = $imagePath;
    }

    /**
     * Retorna o caminho para a imagem convertida
     */
    public function getImagePath ()
    {

        return $this->imagePath;
    }

    /**
     * Converte o ficheiro em imagem
     */
    public function convert ()
    {}
}
?>