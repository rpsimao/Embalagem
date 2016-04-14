<?php

class App_Forms_CortantesTB extends Twitter_Form implements App_Interfaces_ITwitterForm
{


	public function init()
	{

		$this->setMethod('POST');
		$this->setAttribs(array("role"=>"form", "class"=>""));
		$this->setAction('/diecuts/create');



		$estante = new Zend_Form_Element_Text('estante');
		$estante->setLabel('Estante: *');
		$estante->setRequired(TRUE)->setAttribs(array('class'=> "input-small"));
		$this->addElement($estante);

		$codigo = new Zend_Form_Element_Text('codigo');
		$codigo->setLabel('Código: *');
		$codigo->setRequired(TRUE);
		$this->addElement($codigo);


		$cortante = new Zend_Form_Element_Text('cortante');
		$cortante->setLabel('Cortante: *');
		$cortante->setRequired(TRUE)->setAttrib('class', "input-large");
		$this->addElement($cortante);

		//
		$A = new Zend_Form_Element_Text('A');
		$A->setLabel('A:')->setAttrib('class', "input-small");
		$this->addElement($A);

		//
		$B = new Zend_Form_Element_Text('B');
		$B->setLabel('B:')->setAttrib('class', "input-small");
		$this->addElement($B);

		//
		$H = new Zend_Form_Element_Text('H');
		$H->setLabel('H:')->setAttrib('class', "input-small");
		$this->addElement($H);

		//
		$f = new Zend_Form_Element_Text('f');
		$f->setLabel('f:')->setAttrib('class', "input-small");
		$this->addElement($f);

		//
		$g = new Zend_Form_Element_Text('g');
		$g->setLabel('g:')->setAttrib('class', "input-small");
		$this->addElement($g);

		//
		$pala = new Zend_Form_Element_Text('pala');
		$pala->setLabel('Pala:')->setAttrib('class', "input-small");
		$this->addElement($pala);

		//
		$tipo = new Zend_Form_Element_Text('tipo');
		$tipo->setLabel('Tipo:')->setAttrib('class', "input-small");
		$this->addElement($tipo);

		//
		$formato_util = new Zend_Form_Element_Text('formato_util');
		$formato_util->setLabel('Formato util:');
		$this->addElement($formato_util);

		//
		$formato_otimizado = new Zend_Form_Element_Text('formato_otimizado');
		$formato_otimizado->setLabel('Formato Otimizado:');
		$this->addElement($formato_otimizado);

		//
		$formato_entrada = new Zend_Form_Element_Text('formato_entrada');
		$formato_entrada->setLabel('Formato entrada:');
		$this->addElement($formato_entrada);

		//
		$espaco = new Zend_Form_Element_Text('espaco');
		$espaco->setLabel('Espaço:')->setAttrib('class', "input-small");
		$this->addElement($espaco);

		//
		$braille1 = new Zend_Form_Element_Text('braille1');
		$braille1->setLabel('Braille:');
		$this->addElement($braille1);

		//
		$braille2 = new Zend_Form_Element_Text('braille2');
		$braille2->setLabel('Braille Caracteres:');
		$this->addElement($braille2);

		//
		$braille3 = new Zend_Form_Element_Text('braille3');
		$braille3->setLabel('Braille Posição:');
		$this->addElement($braille3);

		//
		$formato_std = new Zend_Form_Element_Text('formato_std');
		$formato_std->setLabel('Formato Standard:');
		$this->addElement($formato_std);

		//
		$descasque = new Zend_Form_Element_Select('descasque');
		$descasque->setLabel('Descasque:');
		$descasque->addMultiOptions(array(
			'' => 'Escolha uma opção:' ,
			'S' => 'Sim' ,
			'N' => 'Não'))->setAttrib('class', "input-large");
		$this->addElement($descasque);

		//
		$obs = new Zend_Form_Element_Textarea('obs');
		$obs->setLabel('Obs')->setAttribs(array('rows'=>7,'cols'=>50));
		$this->addElement($obs);

		$alt = new Zend_Form_Element_Textarea('alteracoes');
		$alt->setLabel('Alterações')->setAttribs(array('rows'=>7,'cols'=>50));
		$this->addElement($alt);
		//
		$submit = New Zend_Form_Element_Submit('submit');
		$submit->setLabel('Enviar');
		$this->addElement($submit);



	}

}