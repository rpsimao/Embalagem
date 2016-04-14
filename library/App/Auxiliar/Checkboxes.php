<?php
/**
 * Classe para transformar o valor das checkboxes em linguagem e o reverso
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 */

class App_Auxiliar_Checkboxes
{

    /**
     * 
     * Transforma Sim ou Não em 0 ou 1
     * @param string $value
     * @return int
     */
    public static function translateCheckboxes ($value)
    {

        $number = ($value == 'Sim') ? 1 : 0;
        return $number;
    }

    /**
     * Transforma 0 ou 1 Sim ou Não
     * @param int $value
     * @return string
     */
    public static function reverseTranslateCheckboxes ($value)
    {

        $string = ($value == 0) ? 'Não' : 'Sim';
        return $string;
    }
}
?>