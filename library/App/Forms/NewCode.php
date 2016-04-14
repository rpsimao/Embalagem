<?php

/**
 * Formulário criar novo registo
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 19/10/2009
 */
class App_Forms_NewCode extends App_Abstract_Forms implements App_Interfaces_IForm
{

    /**
     * 
     * @return Zend_Form
     */
    public static function getForm ()
    {

        $decorators= array(
        'ViewHelper','Errors',
        array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr')),
        );
        $submitDecorator=array('ViewHelper',
        array(array('data' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element')),
        array(array('emptyrow' => 'HtmlTag'),  array('tag' =>'td', 'class'=> 'element', 'placement' => 'PREPEND')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
        );
        
        
        
        $obra = new Zend_Form_Element_Text('obra');
        $obra->setLabel('Nº Obra: *')
        ->setRequired(TRUE)
        ->addValidator(new Zend_Validate_StringLength(5, 5))
        ->addValidator(new Zend_Validate_Int())
        ->setErrorMessages(array(self::ERR_COD_F3, self::ERR_ONLY_NUMBERS_ALLOWED))
        ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
        ->setAttrib('onblur', 'getObraInfo();')
        ->setDecorators($decorators);
        //        
        $codinterno = new Zend_Form_Element_Text('cod_interno');
        $codinterno->setLabel('Cód. Interno: *')
        ->setRequired(TRUE)
        ->addValidator(new Zend_Validate_StringLength(5, 5))
        ->addValidator(new Zend_Validate_Int())
        ->setErrorMessages(array(self::ERR_COD_F3, self::ERR_ONLY_NUMBERS_ALLOWED))
        ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
        ->setDecorators($decorators);
        
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Produto: *')
        ->setRequired(TRUE)
        ->addErrorMessage(self::ERR_EMPTY_FIELD)
        ->setAttrib('class', self::CLASS_BOX_TYPE_LARGE)
        ->setDecorators($decorators);
        //
        $numversao = new Zend_Form_Element_Text('versao');
        $numversao->setLabel('Nº Versão: *')
        ->setRequired(TRUE)
        ->addValidator(new Zend_Validate_Int())
        ->addErrorMessage(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED)
        ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
        ->setDecorators($decorators);
        //
        $numedicao = new Zend_Form_Element_Text('edicao');
        $numedicao->setLabel('Nº Edição: *')
        ->setRequired(TRUE)
        ->addValidator(new Zend_Validate_Int())
        ->addErrorMessage(self::ERR_EMPTY_FIELD, self::ERR_ONLY_NUMBERS_ALLOWED)
        ->setAttrib('class', self::CLASS_BOX_TYPE_SMALL)
        ->setDecorators($decorators);
        
        $codcliente = new Zend_Form_Element_Text('cod_cliente');
        $codcliente->setLabel('Cód. Cliente: *')
        ->setRequired(TRUE)
        ->addErrorMessage(self::ERR_EMPTY_FIELD)
        ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
        ->setDecorators($decorators);
        
        $dimensoes = new Zend_Form_Element_Text('dimensoes');
        $dimensoes->setLabel('Dimensões: *')
        ->setRequired(TRUE)
        ->addErrorMessage(self::ERR_EMPTY_FIELD)
        ->setAttrib('class', self::CLASS_BOX_TYPE_LARGE)
        ->setDecorators($decorators);
        
        $cortante = new Zend_Form_Element_Text('cortante');
        $cortante->setLabel('Cortante: *')
        ->setRequired(TRUE)
        ->addErrorMessage(self::ERR_EMPTY_FIELD)
        ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
        ->setDecorators($decorators);
        
        $cores = new Zend_Form_Element_Text('cores');
        $cores->setLabel('Cores: *')
        ->setRequired(TRUE)
        ->addErrorMessage(self::ERR_EMPTY_FIELD)
        ->setAttrib('class', self::CLASS_BOX_TYPE_LARGE)
        ->setDecorators($decorators);
        
        $vernizMaquina = new Zend_Form_Element_Select('verniz_maquina');
        $vernizMaquina->setLabel('Verniz Máquina: *')
                      ->setRequired(TRUE)
                      ->addErrorMessage(self::ERR_EMPTY_FIELD)
                      ->setMultiOptions(array(''=>'Escolha uma opção','0'=>'Não', '1'=>'Sim'))
                      ->setDecorators($decorators);
        
        $vernizUV = new Zend_Form_Element_Select('verniz_uv');
        $vernizUV->setLabel('Verniz UV: *')
                      ->setRequired(TRUE)
                      ->addErrorMessage(self::ERR_EMPTY_FIELD)
                      ->setMultiOptions(array(''=>'Escolha uma opção','0'=>'Não', '1'=>'Sim'))
                      ->setDecorators($decorators);
                      
                      $plastificacao = new Zend_Form_Element_Select('plastificacao');
        $plastificacao->setLabel('Plastificação: *')
                      ->setRequired(TRUE)
                      ->addErrorMessage(self::ERR_EMPTY_FIELD)
                      ->setMultiOptions(array(''=>'Escolha uma opção','0'=>'Não', '1'=>'Sim'))
                      ->setDecorators($decorators);
                      
                      $estampagem = new Zend_Form_Element_Select('estampagem');
        $estampagem->setLabel('Estampagem: *')
                      ->setRequired(TRUE)
                      ->addErrorMessage(self::ERR_EMPTY_FIELD)
                      ->setMultiOptions(array(''=>'Escolha uma opção','0'=>'Não', '1'=>'Sim'))
                      ->setDecorators($decorators);
                      
        $braille = new Zend_Form_Element_Select('braille');
        $braille->setLabel('Braille: *')
                      ->setRequired(TRUE)
                      ->addErrorMessage(self::ERR_EMPTY_FIELD)
                      ->setMultiOptions(array(''=>'Escolha uma opção','0'=>'Não', '1'=>'Sim'))
                      ->setDecorators($decorators);
        
        $data_entrega = new Zend_Form_Element_Text('data_entrega');
        $data_entrega->setLabel('Data Entrega: *')
             ->setRequired(TRUE)
             ->addErrorMessage(self::ERR_EMPTY_FIELD)
             ->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM)
             ->setDecorators($decorators);
        //
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        $submit->setDecorators($submitDecorator);
        
        return array(
            $codinterno ,
            $produto,
            $codcliente,
            $dimensoes,
            $cortante,
            $cores,
            $vernizMaquina,
            $vernizUV,
            $plastificacao,
            $estampagem,
            $braille,
            $numversao , 
            $numedicao ,
            $data_entrega , 
            $obra ,
            $submit);
        /*
        $form = new Zend_Form();
        $form->setMethod('post')->setAction('/labs/insertrecord')->addElements(array(
            $obra ,
            $codinterno , 
            $codcliente , 
            $numversao , 
            $numedicao ,
            $dimensoes,
            $cores,
            $vernizmaq,
            $vernizuv,
            $data , 
            $cortante , 
            $submit))->setAttrib('id', 'newcode')->setDecorators(array(
            'FormElements' , 
            array(
                'HtmlTag' , 
                array(
                    'tag' => 'ul')) , 
            'Form'));
        return $form;*/
    }
}
?>