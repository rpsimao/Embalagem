<?php

/** 
 * @author rpsimao
 * 
 */
class App_User_Service_Frases extends App_Master_DB_Embalagem
{

    public function __construct ()
    {

        parent::__construct();
        $this->frases = new Frases();
    }

    public function findByID ($id)
    {

        return $this->frases->find($id)->toArray();
    }
}