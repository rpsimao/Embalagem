<?php
/**
 * Formulário para o arquivo de chapas
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 22/10/2009
 */
class App_Forms_ArquivoChapasEditRecord extends Twitter_Form implements App_Interfaces_ITwitterForm
{

	public function init()
	{

		$this->setMethod('POST');
		$this->setAttribs(array("role"=>"form", "class"=>""));
		//$this->setAction('/arquivochapas/update');



		$codigof3 = new Zend_Form_Element_Text('codigof3');
		$codigof3->setLabel('Insira o Código F3:*')
			->setRequired(TRUE)
			->setAttribs(array('class'=> "input-small", "autocomplete" => "off"));
		$this->addElement($codigof3);

		//
		$cortante = new Zend_Form_Element_Text('cortante');
		$cortante->setLabel('Insira o Nº do Cortante:*')
			->setRequired(TRUE)
			->addFilter(new Zend_Filter_StripTags())
			->addFilter(new Zend_Filter_HtmlEntities())
			->setAttribs(array('class'=> "input-small", "autocomplete" => "off"));
		$this->addElement($cortante);
		//
		$versao = new Zend_Form_Element_Text('versao');
		$versao->setLabel('Insira o Nº da Versão:*')
			->setRequired(TRUE)
			->addValidator(new Zend_Validate_Int())
			->setAttribs(array('class'=> "input-small", "autocomplete" => "off"));
		$this->addElement($versao);
		//
		$produto = new Zend_Form_Element_Text('produto');
		$produto->setLabel('Insira o Nome do Produto:*')
			->setRequired(TRUE)
			->setErrorMessages(array(self::ERR_EMPTY_FIELD))
			->setAttrib('class', "input-large");
		$this->addElement($produto);
		//
		$_700x1000 = new Zend_Form_Element_Text('700x1000');
		$_700x1000->setLabel('700x1000:');
		$this->addElement($_700x1000);
		//
		$_1000x700 = new Zend_Form_Element_Text('1000x700');
		$_1000x700->setLabel('1000x700:');
		$this->addElement($_1000x700);
		//
		$_800x700 = new Zend_Form_Element_Text('800x700');
		$_800x700->setLabel('800x700:');
		$this->addElement($_800x700);
		//
		$_700x800 = new Zend_Form_Element_Text('700x800');
		$_700x800->setLabel('700x800:');
		$this->addElement($_700x800);
		//
		$_000x000 = new Zend_Form_Element_Text('000x000');
		$_000x000->setLabel('000x000:');
		$this->addElement($_000x000);
		//
		$_550x800 = new Zend_Form_Element_Text('550x800');
		$_550x800->setLabel('550x800:');
		$this->addElement($_550x800);
		//
		$_698x498 = new Zend_Form_Element_Text('698x498');
		$_698x498->setLabel('698x498:');
		$this->addElement($_698x498);
		//
		$_698x398 = new Zend_Form_Element_Text('698x398');
		$_698x398->setLabel('698x398:');
		$this->addElement($_698x398);
		//
		$_698x332 = new Zend_Form_Element_Text('698x332');
		$_698x332->setLabel('698x332:');
		$this->addElement($_698x332);
		//
		$options = array(
			'AUTOPLATINA' => 'Autoplatina',
			'CILINDRICA'  => 'Cilindrica',
			'CONTENTORA'  => 'Contentora',
			'CANELADO'    => 'Canelado');
		//
		$tipo = new Zend_Form_Element_Radio('tipo');
		$tipo->setLabel('Tipo:*')
			->setRequired(true)
			->setOptions(array('separator' => '&nbsp;&nbsp;'))
			->setErrorMessages(array(self::ERR_EMPTY_FIELD))
			->setMultiOptions($options);
		$this->addElement($tipo);
		//
		$arquivo = new Zend_Form_Element_Text('arquivo');
		$arquivo->setLabel('Caixa Nº:*')
			->setRequired(TRUE)
			->addValidator(new Zend_Validate_Int())
			->setAttribs(array('class'=> "input-small", "autocomplete" => "off"));
		$this->addElement($arquivo);
		//
		$submit = New Zend_Form_Element_Submit('submit');
		$submit->setLabel('Enviar');
		$this->addElement($submit);
	}
}