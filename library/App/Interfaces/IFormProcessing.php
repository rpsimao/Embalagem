<?php
/**
 * Interface para processar os formulários
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
interface App_Interfaces_IFormProcessing
{

    function getForm (Zend_Form $form);

    function processForm ();
}
?>