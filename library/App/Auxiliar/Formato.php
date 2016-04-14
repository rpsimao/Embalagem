<?php

/**
 *Altera os astericos no formato do trabalho para x
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database@author rpsimao
 *
 */
class App_Auxiliar_Formato
{

    /**
     * Trocar os * por x no formato do trabalho
     * @param data $string
     * @return string
     */
    public static function replaceAst ($data)
    {

        $find = "*";
        $replace = "x";
        $final = str_replace($find, $replace, $data);
        return $final;
    }
}
?>