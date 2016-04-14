<?php

class TestSearch extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function testCanSearchByBetweenDates()
    {
        
        $optimus = new App_User_Service_Optimus();
        $optimus->searchBetweenDates('2010-02-23','2010-02-26');
        
        
    }
}