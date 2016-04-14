<?php
/**
 * IndexController
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
require_once 'Zend/Controller/Action.php';

class IndexController extends Zend_Controller_Action
{



   public function init(){


	  $this->_helper->layout()->setLayout('layout-iso-bootstrap-homepage');
   }

    /**
     * The default action - Mostra o menu
     */
    public function indexAction ()
    {
    // TODO Auto-generated IndexController::indexAction() default action

	   $this->_helper->viewRenderer->setRender('newindex');

    }

    public function backAction ()
    {
    
    $ft = new App_Calculations_BraillePrice();
    echo $ft->setMaleLenghtFinalValue ();
    echo "<br /><br />";
    echo $ft->setMaleHeightFinalValue ();  
    }
}
?>

