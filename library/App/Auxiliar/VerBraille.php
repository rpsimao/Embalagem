<?php

/** 
 * @author rpsimao
 * 
 */
class App_Auxiliar_VerBraille
{

    /**
     * Procura se existe uma ligação para outro Braille
     *
     * @param string $haystack            
     */
    public static function Search ($haystack)
    {

        $needle = "ver";
        if (strpos($haystack, $needle) !== false) {
            $NumericVal = preg_replace("/[^0-9]+/", "", $haystack);
            return '<a href="/arqbraille/edit/' . $NumericVal . '">' . $haystack . "</a>";
        }
    }
    
    
    /**
     * Mostra a imagem da cx baseado no Cod F3
     * @param string $f3code
     */
    public static function DisplayImage($f3code)
    {
        $f3code = str_replace('e', ',', $f3code);
        
        $needle = ",";
        $v = "";
        
        if (strpos($f3code, $needle) !== false) {
            
            $multiple = explode(",", $f3code);
            $multiple = array_filter($multiple);
            
            foreach ($multiple as $value) 
            {
                $unid = uniqid();
                $value = str_replace(" ", "", $value);
                
                
                if (strlen($value) > 8)
                {
                    $NumericVal = preg_replace("/[^0-9]+/", "", $value);
                    $NumericVal = substr($NumericVal, 0, -2);
                    $v.= '<span id="'.$NumericVal.'-'.$unid.'" onmouseover="displayImage(\''.$NumericVal."-".$unid.'\')">' . $value . ", </span>";

                } else {
                    $NumericVal = substr($NumericVal, 3);
                    $v.= '<span id="'.$NumericVal.'-'.$unid.'" onmouseover="displayImage(\''.$NumericVal."-".$unid.'\')">' . $value . ", </span>";
                }
                
                
                
                
            }
             return $v;
            
        } else {
            $unid = uniqid();
            
            if (strlen($f3code) > 8)
            {
                $NumericVal = preg_replace("/[^0-9]+/", "", $f3code);
                $NumericVal = substr($NumericVal, 0, -2);
                $v.= '<span id="'.$NumericVal.'-'.$unid.'" onmouseover="displayImage(\''.$NumericVal."-".$unid.'\')">' . $f3code . "</span>";
            
            } else {
                $NumericVal = substr($f3code, 3);
                $v.= '<span id="'.$NumericVal.'-'.$unid.'" onmouseover="displayImage(\''.$NumericVal."-".$unid.'\')">' . $f3code . ", </span>";
            }
            
            
            
            
            return $v;
        }  
        
    }
    
    public static function DisplayObraInfo($numObra)
    {
        
        $needle = ",";
        $v = "";
        
        
        if (strpos($numObra, $needle) !== false) {
            
            $multiple = explode(",", $numObra);
            $multiple = array_filter($multiple);
            
            foreach ($multiple as $value)
            {
                $unid = uniqid();
                $value = str_replace(" ", "", $value);
                $v.= '<span id="'.$value.'-'.$unid.'" onmouseover="displayObraInfo(\''.$value."-".$unid.'\')">' . $value . ", </span>";
            }
            
        } else {
            $unid = uniqid();
            $v.= '<span id="'.$numObra.'-'.$unid.'" onmouseover="displayObraInfo(\''.$numObra."-".$unid.'\')">' . $numObra . "</span>";
            
        }
       return $v; 
    }
    
}
?>