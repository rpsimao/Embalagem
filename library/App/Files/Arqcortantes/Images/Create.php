<?php

class App_Files_Arqcortantes_Images_Create extends App_Abstract_Images
{

    public function convert ()
    {

        try {
            exec("convert \"{$this->getPath()}\" -colorspace RGB -geometry " . $this->getSize() . " \"{$this->getImagePath()}\"");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>