<?php

/**
 * Formulário para criação do Selo
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_Forms_Obra extends Zend_Form
{

    /**
     * Define os erros para apresentar ao utilizadores
     *
     */
    const ERR_EMPTY_FIELD = '* Este campo não pode estar vazio.';

    const ERR_LENGHT_PASSWD = '* A palavra passe tem de ter entre 4 e 12 caracteres.';

    const ERR_COD_F3 = '* Este campo tem de ter entre 5 e 7 algarismos.';

    const ERR_EMAIL_MALFORMED = '* O endereço de email não é válido';

    const ERR_ONLY_NUMBERS_ALLOWED = "* Este campo só pode conter algarismos.";

    /**
     * Define os estilos CSS para a form
     */
    const CLASS_BOX_TYPE_MINI = 'rounded-textbox_mini';

    const CLASS_BOX_TYPE_SMALL = 'rounded-textbox_small';

    const CLASS_BOX_TYPE_MED = 'rounded-textbox_med';
    
    const CLASS_BOX_TYPE_MEDIUM = 'rounded-textbox_medium';

    const CLASS_BOX_TYPE_LARGE = 'rounded-textbox_large';

    const CLASS_BOX_TYPE_DATA = 'rounded-textbox_data';

    /**
     * Gera um array para o número de provas e de edição
     * @return array
     */
    private function generateNumbersArray ()
    {

        $i = 0;
        $numbers = array();
        for ($i = 0; $i <= 100; $i ++) {
            $numbers[$i] = $i;
        }
        return $numbers;
    }

    /**
     * 
     * @see App_Interfaces_IForm::getForm()
     */
    public function init ()
    {

        $this->setMethod('post');
        $this->setAction('/obra/update/g');
        /*$decorators = array(array('ViewHelper') ,array('Errors') ,array('Label') , array('HtmlTag' ,array('tag' => 'tr')));
        $decorators1 = array(array('ViewHelper') ,array('Errors') ,array('Label') , array('HtmlTag' ,array('tag' => 'tr', 'id'=>'espessura-element')));*/
        
        $cliente = New Zend_Form_Element_Text('cliente');
        $cliente->setLabel('Cliente: *');
        $cliente->setRequired(TRUE);
        $cliente->addErrorMessage(self::ERR_EMPTY_FIELD);
        $cliente->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        //
        $produto = new Zend_Form_Element_Text('produto');
        $produto->setLabel('Produto: *');
        $produto->setRequired(TRUE);
        $produto->addErrorMessage(self::ERR_EMPTY_FIELD);
        $produto->setAttrib('class', self::CLASS_BOX_TYPE_LARGE);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $formato = new Zend_Form_Element_Text('formato');
        $formato->setLabel('Formato: *');
        $formato->setRequired(TRUE);
        $formato->addErrorMessage(self::ERR_EMPTY_FIELD);
        $formato->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $reedicao = new Zend_Form_Element_Select('edicao');
        $reedicao->setLabel('Edi&ccedil;&atilde;o N&ordm;: *');
        $reedicao->setRequired(TRUE);
        $reedicao->addErrorMessage(self::ERR_EMPTY_FIELD);
        $reedicao->addMultiOptions($this->generateNumbersArray());
        $reedicao->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        
        
        
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $cartolina = new Zend_Form_Element_Select('cartolina');
        $cartolina->setLabel('Cartolina: *');
        $cartolina->setRequired(TRUE);
        $cartolina->addErrorMessage(self::ERR_EMPTY_FIELD);
        $cartolina->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        $cartolina->setAttrib('onchange', 'getEsp();');
        $cartolina->addMultiOption('', 'Escolha o Tipo:');
        
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $cartolinaTypes = new App_User_Service_Cartolina();
        foreach ($cartolinaTypes->getValues() as $type) {
            $cartolina->addMultiOptions(array(
                $type->tipo . '/' . $type->gramagem . 'g' => $type->tipo . '/' . $type->gramagem . 'g'));
        }
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $espessura = new Zend_Form_Element_Text('espessura');
        $espessura->setLabel('Espessura:');
        $espessura->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
       /**
        * 
        * Enter description here ...
        * @var unknown_type
        */
        $codProduto = new Zend_form_Element_Text('codproduto');
        $codProduto->setLabel('C&oacute;digo Produto:');
        $codProduto->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $codLaetus = new Zend_Form_Element_Text('codlaetus');
        $codLaetus->setLabel('C&oacute;digo Laetus:');
        $codLaetus->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $codVisual = new Zend_Form_Element_Text('codvisual');
        $codVisual->setLabel('C&oacute;digo Visual:');
        $codVisual->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $codF3 = new Zend_Form_Element_Text('codf3');
        $codF3->setLabel('C&oacute;digo F3 *:');
        $codF3->setRequired(TRUE);
        $codF3->addValidator(new Zend_Validate_StringLength(5, 7));
        $codF3->addErrorMessage(self::ERR_COD_F3);
        $codF3->setAttribs(array('class'=> self::CLASS_BOX_TYPE_SMALL, 'onblur' => 'f3CodValidator();'));
        
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $numCores = new Zend_Form_Element_Text('numcores');
        $numCores->setLabel('N&ordm; de Cores: *');
        $numCores->setAttrib('class', self::CLASS_BOX_TYPE_MEDIUM);
        $numCores->setRequired(TRUE);
        $numCores->addErrorMessage(self::ERR_EMPTY_FIELD);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $vernizMaq = new Zend_Form_Element_Checkbox('vernizmaq');
        $vernizMaq->setLabel('Verniz M&aacute;quina:');
        $vernizMaq->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $vernizUV = new Zend_Form_Element_Checkbox('vernizuv');
        $vernizUV->setLabel('Verniz UV:');
        $vernizUV->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $braille = new Zend_Form_Element_Checkbox('braille');
        $braille->setLabel('Braille:');
        $braille->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $vernizAgua = new Zend_Form_Element_Checkbox('vernizagua');
        $vernizAgua->setLabel('Verniz &Aacute;gua:');
        $vernizAgua->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         *
         * Enter description here ...
         * @var unknown_type
         */
        $plastificacao = new Zend_Form_Element_Checkbox('plastificacao');
        $plastificacao->setLabel('Plastifica&ccedil;&atilde;o:');
        $plastificacao->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         *
         * Enter description here ...
         * @var unknown_type
         */
        $estampagem = new Zend_Form_Element_Checkbox('estampagem');
        $estampagem->setLabel('Estampagem:');
        $estampagem->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         *
         * Enter description here ...
         * @var unknown_type
         */
        $picote = new Zend_Form_Element_Checkbox('picote');
        $picote->setLabel('Picote:');
        $picote->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         *
         * Enter description here ...
         * @var unknown_type
         */
        $relevo = new Zend_Form_Element_Checkbox('relevo');
        $relevo->setLabel('Relevo:');
        $relevo->setAttrib('class', self::CLASS_BOX_TYPE_MINI);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $numProva = new Zend_Form_Element_Select('prova');
        $numProva->setLabel('N&ordm; da Prova: *');
        $numProva->setRequired(TRUE);
        $numProva->addErrorMessage(self::ERR_EMPTY_FIELD);
        $numProva->addMultiOptions($this->generateNumbersArray());
        $numProva->setAttrib('class', self::CLASS_BOX_TYPE_SMALL);
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $submit = New Zend_Form_Element_Submit('submit');
        $submit->setLabel('Enviar');
        /**
         * 
         * Enter description here ...
         * @var unknown_type
         */
        $obra = new Zend_Form_Element_Hidden('numobra');
        $this->addElements(array(
            $cliente , 
            $produto , 
            $formato , 
            $reedicao , 
            $cartolina , 
            $espessura , 
            $codProduto , 
            $codLaetus , 
            $codVisual , 
            $codF3 , 
            $numCores , 
            $vernizMaq , 
            $vernizUV , 
            $vernizAgua ,
            $plastificacao ,
            $estampagem ,
            $braille , 
            $picote ,
            $relevo ,
            $numProva , 
            $submit , 
            $obra));
            $this->setElementDecorators(array(
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
            array('HtmlTag', array('tag' => 'table')),
            'Form'
        ));
    }
}
