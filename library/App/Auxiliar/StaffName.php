<?php

class App_Auxiliar_StaffName
{

    public static function getName ($code)
    {

        $optimus = new App_User_Service_Optimus();
        $name = $optimus->getStaffNameByCode($code);
        return $name['staf_name'];
    }
}