<?php

class Testmonths extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function testfuckinkmonths ()
    {

        $this->optimus = new App_User_Service_Optimus();
        if (date('l') == 'Friday') {
            $today = new Zend_Date();
            $dayT = $today->add('3', Zend_Date::DAY);
            $tomorrow = date('Y') . '-' . $this->changeMonth($dayT) . '-' . $dayT;
            echo $tomorrow;
        }
    }
}