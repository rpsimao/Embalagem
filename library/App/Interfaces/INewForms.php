<?php

interface App_Interfaces_INewForms
{


    /**
     * Constroi o formulário;
     */
    function buildForm ();

    /**
     * Mostra o formulário
     */
   function displayForm ();

    /**
     * Mostra o formulário com valores
     * @param $params
     */
    function displayFormWithPopulate (array $params);
}
?>