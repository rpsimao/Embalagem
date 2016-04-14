<?php

/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 09/11/15
 * Time: 17:21
 */
class App_View_Helper_EnvVar extends Zend_View_Helper_Abstract
{
    public function EnvVar()
    {

        if (APPLICATION_ENV == "development")
        {
            $html =  '<div class="pull-right"><span class="label label-danger label-white middle" style="margin-top: 5px">DEVELOPMENT</span></div>';

            return $html;
        }

    }
}
