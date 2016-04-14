<?php

class App_Change
{

    public static function date ($date)
    {

        $explode = explode("-", $date);
        $length = strlen($explode[0]);
        $characters = 2;
        $start = $length - $characters;
        $time = substr($explode[0], $start, $characters);
        $cleanDate = $explode[2] . "/" . self::month($explode[1]) . "/" . $time;
        return $cleanDate;
    }

    public static function fundo ($type)
    {

        $explode = explode(" ", $type);
        
        if (@$explode[2] == NULL){
            $fundo = $explode[1];
        } else {
            $fundo = $explode[2];
        }
        
        return $fundo;
    }

    private function month ($month)
    {

        switch ($month) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Fev";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Abr";
                break;
            case 5:
                return "Mai";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ago";
                break;
            case 9:
                return "Set";
                break;
            case 10:
                return "Out";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Dez";
                break;
        }
    }
}