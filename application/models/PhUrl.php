<?php

class Application_Model_PhUrl
{

    protected $settings;
    protected $urls;
    
    function __construct ()
    {
        $config = Zend_Registry::get('phpurl');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    
    
    
    
    
    }

}

