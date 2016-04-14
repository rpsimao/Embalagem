<?php

class App_Forms_Dossiers extends Zend_Form
{

    public function init ()
    {

        $this->setMethod('post');
        $this->setAction('/test/insert');
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $num = new Zend_Form_Element_Text('numero');
        $num->setLabel('Número de Vezes:');
        $num->setRequired(TRUE);
        $num->addValidator(new App_Validators_NumeroVezes());
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Nº Cortante');
        $cortante->setRequired(TRUE);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $formato = new App_Forms_Elements_Diecut('formato');
        $formato->setLabel('Formato:');
        $formato->setRequired(TRUE);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $lab = new Zend_Form_Element_Text('lab');
        $lab->setLabel('Lab:');
        $lab->setValue('Ver Dossier');
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $prod = new Zend_Form_Element_Text('prod');
        $prod->setLabel('Prod:');
        $prod->setValue('Ver Dossier');
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $codf3 = new Zend_Form_Element_Text('codf3');
        $codf3->setLabel('Cod F3:');
        $codf3->setValue('Ver Dossier');
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Criar');
        //
        $this->addElements(array(
            $num , 
            $cortante , 
            $formato , 
            $lab , 
            $prod , 
            $codf3 , 
            $submit));
    }
}
?>