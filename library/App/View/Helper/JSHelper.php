<?php
class App_View_Helper_JSHelper extends Zend_View_Helper_Abstract
{

	private $file1 = "";
	private $file2 = "";



	function JSHelper (array $exceptions = array())
    {
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $file_uri = 'js/' . $request->getControllerName() . '/' .
         $request->getActionName() . '.js';
        if (file_exists($file_uri)) {
            $this->file1 =  $this->view->headScript()->appendFile('/' . $file_uri);
        }


	    if ($exceptions)
	    {
		    foreach ($exceptions as $controller => $exception) {

			    if ($request->getControllerName() == $exception) {

				    $this->file2.= $this->view->placeholder("main")->append('<script type="text/javascript" src="/js/'. $controller . '/' .'main.js"></script>');

			    } else if (file_exists("js/". $request->getControllerName() . '/' ."main.js")){
				    $this->file2.= $this->view->placeholder("main")->append('<script type="text/javascript" src="/js/'. $request->getControllerName() . '/' .'main.js"></script>');

				}
		    }
	    }
		else if (file_exists("js/". $request->getControllerName() . '/' ."main.js")){
				    $this->file2.= $this->view->placeholder("main")->append('<script type="text/javascript" src="/js/'. $request->getControllerName() . '/' .'main.js"></script>');

	     }


	    return $this->file1 . $this->file2;

    }

}

