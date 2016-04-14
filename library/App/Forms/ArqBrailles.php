<?php

/**
 *
 *Form for entering values for Brailles Archive
 *
 * @author Ricardo Simão - ricardo.simao@fterceiro.pt
 * @copyright 2011 - Fernandes & Terceiro, SA
 * @copyright All right reserved.
 * @license Although this script is provided with source code it does NOT mean that this report is in the public domain.
 *
 * @version 1.0 - Dec 12, 2012 12:11:14 PM
 *
 * @category Embalagem
 * @package Arquivo Brilles
 *
 */
class App_Forms_ArqBrailles extends Twitter_Form implements App_Interfaces_ITwitterForm
{


    public function init ()
    {


        $this->setMethod('POST');
	    $this->setAttribs(array("horizontal"=>"true", "role"=>"form", "class"=>""));
	    $this->setAction('/arqbraille/create');
        
        $obras = new Zend_Form_Element_Text('obras');
        $obras->setLabel('Obra:')->setRequired(TRUE)->setAttribs(array('class'=> "input-small", "autocomplete"=>"off"));
        $this->addElement($obras);
        
        $nbraille_lab = new Zend_Form_Element_Text('nbraille_lab');
        $nbraille_lab->setLabel('Cliente:')->setRequired(TRUE)->setAttrib('class', "input-small");
        $this->addElement($nbraille_lab);
        
        $nbraille_num = new Zend_Form_Element_Text('nbraille_num');
        $nbraille_num->setLabel('Braille Nº:')->setRequired(TRUE)->setAttribs(array('class'=>'disabled_input input-small', 'readonly'=>'readonly'));
        $this->addElement($nbraille_num);
        
        $nbraille_mes = new Zend_Form_Element_Text('nbraille_mes');
        $nbraille_mes->setLabel('Braille Mês:')->setRequired(TRUE)->setAttrib('class', "input-small");
        $this->addElement($nbraille_mes);
        
        $nbraille_ano = new Zend_Form_Element_Text('nbraille_ano');
        $nbraille_ano->setLabel('Braille Ano:')->setRequired(TRUE)->setAttrib('class', "input-small");
        $this->addElement($nbraille_ano);
        
        $codf3 = new Zend_Form_Element_Text('codf3');
        $codf3->setLabel('Cód F3:')->setRequired(TRUE)->setAttribs(array('class'=>"input-xlarge", "onblur"=> "checkCodF3()"));
        $this->addElement($codf3);
        
        $codcli = new Zend_Form_Element_Text('codcli');
        $codcli->setLabel('Cód. Cliente:')->setRequired(TRUE)->setAttrib('class', "input-xlarge");
        $this->addElement($codcli);
        
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Produto:')->setRequired(TRUE)->setAttrib('class', "input-xxlarge");
        $this->addElement($produto);
        
        $qtd = new Zend_Form_Element_Text('qtd ');
        $qtd ->setLabel('Qtd:')->setRequired(TRUE);
        $this->addElement($qtd );
        
        $b1 = new Zend_Form_Element_Text('b1');
        $b1->setLabel('B1:');
        $this->addElement($b1);
        
        $b2 = new Zend_Form_Element_Text('b2');
        $b2->setLabel('B2:');
        $this->addElement($b2);
        
        $b3 = new Zend_Form_Element_Text('b3');
        $b3->setLabel('B3:');
        $this->addElement($b3);
        
        $b4 = new Zend_Form_Element_Text('b4');
        $b4->setLabel('B4:');
        $this->addElement($b4);
        
        $oc= new Zend_Form_Element_Text('oc');
        $oc->setLabel('Ordem Compra:')->setAttrib('class', "input-xlarge");
        $this->addElement($oc);
        
        $txt = new Zend_Form_Element_Textarea('txtbraille');
        $txt->setLabel('Texto Braille:')->setAttribs(array('rows' => 6, 'cols' =>50 , 'class'=> ""));
        $this->addElement($txt);
        
        $obs = new Zend_Form_Element_Textarea('obs');
        $obs->setLabel('Dados Técnicos:')->setAttribs(array('rows' => 6, 'cols' => 50 , 'class'=> ""));
        $this->addElement($obs);
        
        $obs1 = new Zend_Form_Element_Textarea('obs_txt');
        $obs1->setLabel('Observações:')->setAttribs(array('rows' => 6, 'cols' => 50 , 'class'=> ""));
        $this->addElement($obs1);
        
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $this->addElement($submit);
        
        /*$this->setElementDecorators(array(
                'ViewHelper','Errors',
                array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
                array('Label', array('tag' => 'td')),
                array(array('row' => 'HtmlTag'), array('tag' => 'tr'))));
        
        
        $submit->setDecorators(array('ViewHelper',
                array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
                array(array('emptyrow' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element', 'placement' => 'PREPEND')),
                array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
        ));
        
        
        $this->setDecorators(array(
                'FormElements',
                array('HtmlTag', array('tag' => 'div', 'class'=>'form-group')),
                'Form' ));*/


	    $this->addDisplayGroup(array($obras, $nbraille_lab, $nbraille_num, $nbraille_mes, $nbraille_ano, $nbraille_ano, $codf3, $codcli, $produto, $qtd, $b1, $b2, $b3, $b4), "arqbraillegroup1")->setOrder(1);
	    $this->addDisplayGroup(array($oc, $txt, $obs, $obs1),"arqbraillegroup2")->setOrder(2);
	    $this->addDisplayGroup(array($submit),"arqbraillegroup3")->setOrder(3);
    }
} 