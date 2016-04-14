<?php

class App_GetLabs
{

    /**
     * 
     * @return array
     */
    public static function getLabsName ()
    {

        $labs = new App_User_Service_LabsName();
        $labsName = $labs->getAll();
        foreach ($labsName as $value) {
            $keepvalues[] = array(
                $value['nome'] => $value['num'] . ' - ' . $value['nome']);
        }
        return $keepvalues;
    }

    public static function completeLabs ()
    {

        $labs = new App_User_Service_LabsName();
        $labsName = $labs->getAllSortByName();
        $plus = array(
            "N/ Conform" , 
            "F3", 'Generis', 'Chefaro');
        foreach ($labsName as $value) {
            $keepvalues[] = $value['nome'];
        }
        $complete = array_merge($keepvalues, $plus);
        return $complete;
    }

    public static function changeLabName ($lab)
    {

        switch ($lab) {
            case "Lusomedicamenta":
                $lab = "LUSOMEDICA";
                return $lab;
                break;
            case "Edol":
                $lab = "LAB EDOL";
                return $lab;
                break;
            case "Schering":
                $lab = "Schering F";
                return $lab;
                break;
            case "Coutinho & Alexandre":
                $lab = "COUTINHO A";
                return $lab;
                break;
            default: 
                return $lab;
                break;   
        }
    }
}
?>