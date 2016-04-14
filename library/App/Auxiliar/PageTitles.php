<?php
/**
 * 
 * @author rpsimao
 *
 */

class App_Auxiliar_PageTitles
{

    /**
     * 
     * @var string
     */
    protected $controllerName;

    /**
     * @var $htmlString string
     */
    private $htmlString;

    /**
     * 
     * @param stringe $controllerName
     */
    public function htmlTitle ($controllerName)
    {

        $htmlString = '<div class="f3">' . $controllerName . ' - F3 Embalagem DB </div>';
        return $htmlString;
    }
}
?>