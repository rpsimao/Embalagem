<?php

class App_Service_Cleaners_Colors
{

    public static function stringClean ($string)
    {

        $mistakes = array(
            'SELECÇÃO',
            'SELECÇAO',
            'SELECÃ‡AO' , 
            'SELECCAO' , 
            'CMYK' , 
            'SELECCÃ‡ÃƒO' , 
            '4CORES' , 
            '4 CORES' , 
            'SELEï¿½CAO' , 
            'SELECï¿½AO' , 
            'SELECCï¿½ï¿½O',
            'SELEC&Ccedil;AO',
            'SELECçãO',
            'SELECçAO'
        	
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