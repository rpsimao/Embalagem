<?php

class App_Service_Cleaners_Colors
{

    public static function stringClean ($string)
    {

        $mistakes = array(
            'SELEC��O',
            'SELEC�AO',
            'SELECÇAO' , 
            'SELECCAO' , 
            'CMYK' , 
            'SELECCÇÃO' , 
            '4CORES' , 
            '4 CORES' , 
            'SELE�CAO' , 
            'SELEC�AO' , 
            'SELECC��O',
            'SELEC&Ccedil;AO',
            'SELEC��O',
            'SELEC�AO'
        	
        );
        $string = strtoupper($string);
        $stringArray = explode("+", $string);
        foreach ($stringArray as $value) {
            if (in_array($value, $mistakes)) {
                $clean[] = 'C+M+Y+K';
            } else {
                $clean[] = $value;
            }
            
            
        }
        $finalString = implode("+", $clean);
        
        
        return $finalString;
    }
}
?>