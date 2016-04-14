<?php

class App_Javascript_Date_Helper
{

    /**
     * @var array
     */
    protected $dateFunction = array();

    /**
     * Gera Multiplos calendários
     * @param string $idOfInput
     * @param int $howManyTimes
     * @return array
     */
    public static function generateMultipleDatePickers ($idOfInput, $howManyTimes)
    {

        for ($i = 1; $i <= $howManyTimes; $i ++) {
            $dateFunction[] = "$(function() {\$(\"#$idOfInput$i\").datepicker({ dateFormat: 'yy-mm-dd' , dayNamesMin: ['Dom','Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'], monthNames:['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'] });});";
        }
        return $dateFunction;
    }

    public static function generateSingleDatePickers ($idOfInput)
    {

        $dateFunction = '<script type="text/javascript">';
        $dateFunction .= "$(function() {\$(\"#$idOfInput\").datepicker({ dateFormat: 'yy-mm-dd' , dayNamesMin: ['Dom','Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'], monthNames:['Janeiro', 'Fevereiro', 'Marco', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'] });});";
        $dateFunction .= '</script>';
        return $dateFunction;
    }
}
?>