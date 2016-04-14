<?php

/**
 * 
 * Enter description here ...
 * 
 * @author Ricardo Sim�o - ricardo.simao@fterceiro.pt
 * @copyright 2011 - Fernandes & Terceiro, SA
 * @copyright All right reserved.
 * @license Although this script is provided with source code it does NOT mean that this report is in the public domain.
 * 
 * @version 1.0 - Dec 12, 2012 2:08:21 PM
 * 
 * @category Printshop
 * @package 
 * 
 */
class App_Auxiliar_AddZero
{

    public static function num ($value)
    {

        $add = self::_addZeroNum($value);
        return $add;
    }

    public static function month ($value)
    {

        $add = self::_addZeroMonth($value);
        return $add;
    }
    
    public static function ISOYear ($value)
    {
    
        $add = self::_ISOYear($value);
        return $add;
    }

    
    
    
    private static function _ISOYear($value)
    {
        $length = strlen($value);
        
        switch ($length) {
            case 1:
                return "200" . $value;
                break;
            case 2:
                return "20" . $value;
                break;
        }
    }
    
    
    private static function _addZeroNum ($value)
    {

        $length = strlen($value);
        switch ($length) {
            case 1:
                return "0000" . $value;
                break;
            case 2:
                return "000" . $value;
                break;
            case 3:
                return "00" . $value;
                break;
            case 4:
                return "0" . $value;
                break;
            default:
                return $value;
                break;
        }
    }

    private static function _addZeroMonth ($value)
    {

        $length = strlen($value);
        switch ($length) {
            case 1:
                return "0" . $value;
                break;
            default:
                return $value;
                break;
        }
    }
}

