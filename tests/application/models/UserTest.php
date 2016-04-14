<?php

require APPLICATION_PATH . '/models/EmprovaTable.php';

class UserTest extends Zend_Test_PHPUnit_ControllerTestCase
{

    public function testCanInsertValues ()
    {
        Zend_Registry::set('embalagem', new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.ini', 'embalagem'));

        $t = new EmprovaTable();
        $t->insert(array(
            'obra' => 12345 , 
            'dia' => date('Y-m-d') , 
            'hora' => date('G:H:i'),
            'estado' => 0
        ));
    }
}