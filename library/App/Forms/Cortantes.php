<?php

class App_Forms_Cortantes extends App_Abstract_NewForms
{

    public function buildForm ()
    {
    $decorators = array(array('ViewHelper') ,array('Errors') ,array('Label') , array('HtmlTag' ,array('tag' => 'li')));
        
        $estante = new Zend_Form_Element_Text('estante');
        $estante->setLabel('Estante: *');
        $estante->setRequired(TRUE);
        $estante->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $estante->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $codigo = new Zend_Form_Element_Text('codigo');
        $codigo->setLabel('Código: *');
        $codigo->setRequired(TRUE);
        $codigo->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $codigo->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Cortante: *');
        $cortante->setRequired(TRUE);
        $cortante->setErrorMessages(array(
            self::ERR_EMPTY_FIELD));
        $cortante->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)->setDecorators($decorators);
        //
        $A = new Zend_Form_Element_Text('A');
        $A->setLabel('A:');
        $A->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $B = new Zend_Form_Element_Text('B');
        $B->setLabel('B:');
        $B->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $H = new Zend_Form_Element_Text('H');
        $H->setLabel('H:');
        $H->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $f = new Zend_Form_Element_Text('f');
        $f->setLabel('f:');
        $f->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $g = new Zend_Form_Element_Text('g');
        $g->setLabel('g:');
        $g->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $pala = new Zend_Form_Element_Text('pala');
        $pala->setLabel('Pala:');
        $pala->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $tipo = new Zend_Form_Element_Text('tipo');
        $tipo->setLabel('Tipo:');
        $tipo->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $formato_util = new Zend_Form_Element_Text('formato_util');
        $formato_util->setLabel('Formato util:');
        $formato_util->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $formato_otimizado = new Zend_Form_Element_Text('formato_otimizado');
        $formato_otimizado->setLabel('Formato Otimizado:');
        $formato_otimizado->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $formato_entrada = new Zend_Form_Element_Text('formato_entrada');
        $formato_entrada->setLabel('Formato entrada:');
        $formato_entrada->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $espaco = new Zend_Form_Element_Text('espaco');
        $espaco->setLabel('Espaço:');
        $espaco->setAttrib('class', self::CLASS_BOX_TYPE_MINI)->setDecorators($decorators);
        //
        $braille1 = new Zend_Form_Element_Text('braille1');
        $braille1->setLabel('Braille:');
        $braille1->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $braille2 = new Zend_Form_Element_Text('braille2');
        $braille2->setLabel('Braille Caracteres:');
        $braille2->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $braille3 = new Zend_Form_Element_Text('braille3');
        $braille3->setLabel('Braille Posição:');
        $braille3->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $formato_std = new Zend_Form_Element_Text('formato_std');
        $formato_std->setLabel('Formato Standard:');
        $formato_std->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $descasque = new Zend_Form_Element_Select('descasque');
        $descasque->setLabel('Descasque:');
        $descasque->addMultiOptions(array(
            '' => 'Escolha uma opção:' , 
            'S' => 'Sim' , 
            'N' => 'Não'));
        $descasque->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)->setDecorators($decorators);
        //
        $obs = new Zend_Form_Element_Textarea('obs');
        $obs->setLabel('Obs')->setAttribs(array('rows'=>7,'cols'=>50))->setDecorators($decorators);
        //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        return array(
            $estante , 
            $codigo , 
            $cortante , 
            $A , 
            $B , 
            $H , 
            $f , 
            $g , 
            $pala , 
            $tipo , 
            $formato_util ,
            $formato_otimizado,
            $formato_entrada , 
            $espaco , 
            $braille1 , 
            $braille2 , 
            $braille3 , 
            $formato_std , 
            $descasque,
            $obs,
            $submit);
        //
    }
}
?>