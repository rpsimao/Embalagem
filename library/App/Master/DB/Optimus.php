<?php

/**
 * Master Class para connectar à Base de Dados Optimus
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_Master_DB_Optimus
{
    
    /**
     *  Recupera os valores de acesso à base de dados Embalagem que estão escritos no ficheiro de configurção
     *  Inicializa a conexão
     * @return Zend_Db_Table_Abstract
     */
    function __construct ()
    {
        $config = Zend_Registry::get('optimus');
        $db = Zend_Db::factory($config->database);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
    }
}