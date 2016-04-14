<?php


/**
 *
 * @author rpsimao
 *        
 */
class App_Validators_CodigoLaetusCheck extends Zend_Validate_Abstract
{

    const NOT_MATCH_RECORD = 'recorddoesnotexists';



    protected $_messageTemplates = array(
        self::NOT_MATCH_RECORD => "* O cortante nº%value% não existe.");


    public function isValid ($value)
    {

	    $this->_setValue($value);

	    $model = new App_User_Service_Laetus();
	    $laetus = $model->getAllValuesByCortanteNumber($value);


	    if(count($laetus) > 0 ) {

		    return true;

	    } else {

		        $this->_error(self::NOT_MATCH_RECORD);
		    return false;
	    }

    }
}