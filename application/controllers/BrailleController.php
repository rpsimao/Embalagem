<?php

/** 
 * Controller para criar o Braille
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 27/11/2012
 */
class BrailleController extends Zend_Controller_Action
{

    public function init ()
    {

        //$this->redirect('/arqbraille');
        


    }
    
    public function preDispatch()
    {
        $this->view->setEscape('stripslashes');
	    $this->_helper->layout()->setLayout('layout-iso');
    }

    public function indexAction ()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');

        $form = new App_Forms_Braille;

		$this->view->form = $form;


    }



	public function createbrailleAction()
	{

		//$this->_helper->viewRenderer->setNoRender();
		//$this->_helper->layout->disableLayout();

		$this->_helper->layout()->setLayout('layout-iso-bootstrap');
		/*$filterLatin = new App_Filters_LatinCharsLowerISO8859();
		$values = $filterLatin->filterArray($this->getAllParams());*/

		$values = $this->getAllParams();


		$form = new App_Forms_Braille;
		if ($form->isValid($_POST)) {
			$obra = $values['numobra'];
			$largura = $values['femeaLrg'];
			$altura = $values['femeaAlt'];
			$femea = $values['femea'];
			$cortante = $values['cortante'];
			$texto = utf8_encode($values['texto']);
			//$quantidade = $values['qtd'];


			$brailleDB = new App_User_Service_Braille();
			$brailleDB->insert($obra, $largura, $altura, $femea, $cortante,  utf8_decode($values['texto']));


			//Insere os valores das linhas vertical e horizontal do cortante femea
			$femeaBraille = new App_Calculations_FemaleBraille($largura, $altura);
			$femeaDB = new App_User_Service_FemeaSize();
			if ($cortante == 1) {
				$altura = $femeaBraille->calculateForCCHeight();
				$largura = $femeaBraille->calculateForCCLenght();
				$femeaDB->insert($obra, $altura, $largura);
			} else {
				$altura = $femeaBraille->calculateForCAHeight();
				$largura = $femeaBraille->calculateForCALenght();
				$femeaDB->insert($obra, $altura, $largura);
			}


			$brailleValues = new App_User_Service_Braille();
			$brailleText = $brailleValues->getAll($obra);
			//Calcula o preço do braille Macho
			$male = new App_Calculations_BraillePrice();
			$male->setNumObra($obra);
			$male->setTexto($brailleText['texto']);
			if ($male->checkLastCharOfTextArea($brailleText['texto']) == 0) {
				$errorMsg = "Tem de inserir um Enter no fim do texto do Braille.";
				$errorMsg .= "<br />";
				$errorMsg .= "Volte atr&aacute;s e tente de novo.";
				$this->view->msg = $errorMsg;
			}
			if ($male->checkSecondLastCharOfTextArea($brailleText['texto']) == 0) {
				$errorMsg = "Aten&ccedil;&atilde;o tem mais que um Enter no final do texto.";
				$errorMsg .= "<br />";
				$errorMsg .= "Volte atr&aacute;s e tente de novo.";
				$this->view->msg = $errorMsg;
			}
			if ($male->setMaleLenghtFinalValue() >= $largura) {
				$errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em LARGURA n&atilde;o cabe na caixa.";
				$errorMsg .= "<br />";
				$errorMsg .= "Volte atr&aacute;s e tente de novo.";
				$this->view->msg = $errorMsg;
			}
			if ($male->calculateMaleHeight() > $altura) {
				$errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em ALTURA n&atilde;o cabe na caixa.";
				$errorMsg .= "<br />";
				$errorMsg .= "Volte atr&aacute;s e tente de novo.";
				$this->view->msg = $errorMsg;
			}

			//Verifica se o cortante está bem definido nos comentários do Optimus
			if (!is_numeric($male->getUnidadesDoCortante())) {
				$errorMsg = "O nome do cortante n&atilde;o est&aacute; definido segundo as regras. Corrija no Optimus e volte a tentar.";
				$errorMsg .= "<br />";
				$errorMsg .= "<b>Ex: </b>CA 03383.01 15 UNID";
				$this->view->msg = $errorMsg;
			} else {
				$priceMale = $male->calculateMalePrice();
				if ($femea == 1) {
					$priceFemale = $male->firstFemaleCalculation();
				} else {
					$priceFemale = 0;
				}
				/**
				 * Testes
				 */
				//$this->view->altura = $altura;
				$this->view->texto = $texto;
				$this->view->getUnidadesdoCortante = $male->getUnidadesdoCortante();
				$this->view->formatTextforCount = $male->formatTextforCount();
				$this->view->calculateMaleLenght = $male->calculateMaleLenght();
				$this->view->calculateMaleHeight = $male->calculateMaleHeight();
				$this->view->setMaleLenghtFinalValue = $male->setMaleLenghtFinalValue();
				$this->view->setMaleHeightFinalValue = $male->setMaleHeightFinalValue();
				$this->view->getFirstChar = $male->getFirstChar();
				$this->view->getLastChar = $male->getLastChar();
				//print_r($male->getFirstChar());
				//print_r($male->checkFirstCharOfAllParagraphs());
				/**
				 * Fim de teste
				 */
				$braillePrice = new App_User_Service_BrailleValue();
				$braillePrice->insert($obra, $priceMale, $priceFemale);
				$this->view->priceFemale = $priceFemale;
				$this->view->priceMale = $priceMale;
				$this->view->pdfLink = $obra;

			}
		} else {
				// Se o formulário não estiver bem preenchido retorna o formulário com os respectivos erros.
				$this->view->errors = $form->getMessages();
				$this->view->form = $form;
			}


		}





	public function createAction ()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
        $filterLatin = new App_Filters_LatinCharsLowerISO8859();
        
        $form = new App_Forms_Braille;
        if ($form->isValid($_POST)) {
            $filterValues = new Zend_Filter_StripTags();
            $obra       = $filterValues->filter($this->_request->getPost('numobra'));
            $largura    = $filterValues->filter($this->_request->getPost('femeaLrg'));
            $altura     = $filterValues->filter($this->_request->getPost('femeaAlt'));
            $femea      = $filterValues->filter($this->_request->getPost('femea'));
            $cortante   = $filterValues->filter($this->_request->getPost('cortante'));
            $texto      = $filterValues->filter($filterLatin->filter($this->_request->getPost('texto')));
            $quantidade = $filterValues->filter($this->_request->getPost('qtd'));
            //Insere valores na base de dados
            $brailleDB = new App_User_Service_Braille();
            $brailleDB->insert($obra, $largura, $altura, $femea, $cortante, $texto);
            //Insere os valores das linhas vertical e horizontal do cortante femea
            $femeaBraille = new App_Calculations_FemaleBraille($largura, $altura, $quantidade);
            $femeaDB = new App_User_Service_FemeaSize();
            if ($cortante == 1) {
                $altura = $femeaBraille->calculateForCCHeight();
                $largura = $femeaBraille->calculateForCCLenght();
                $femeaDB->insert($obra, $altura, $largura);
            } else {
                $altura = $femeaBraille->calculateForCAHeight();
                $largura = $femeaBraille->calculateForCALenght();
                $femeaDB->insert($obra, $altura, $largura);
            }
            $brailleValues = new App_User_Service_Braille();
            $brailleText = $brailleValues->getAll($obra);
            //Calcula o preço do braille Macho
            $male = new App_Calculations_BraillePrice();
            $male->setNumObra($obra);
            $male->setTexto($brailleText['texto']);
            if ($male->checkLastCharOfTextArea($brailleText['texto']) == 0) {
                $errorMsg = "Tem de inserir um Enter no fim do texto do Braille.";
                $errorMsg .= "<br />";
                $errorMsg .= "Volte atr&aacute;s e tente de novo.";
                $this->view->msg = $errorMsg;
            }
            if ($male->checkSecondLastCharOfTextArea($brailleText['texto']) == 0) {
                $errorMsg = "Aten&ccedil;&atilde;o tem mais que um Enter no final do texto.";
                $errorMsg .= "<br />";
                $errorMsg .= "Volte atr&aacute;s e tente de novo.";
                $this->view->msg = $errorMsg;
            }
            if ($male->setMaleLenghtFinalValue() >= $largura){
                $errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em LARGURA n&atilde;o cabe na caixa.";
                $errorMsg .= "<br />";
                $errorMsg .= "Volte atr&aacute;s e tente de novo.";
                $this->view->msg = $errorMsg;
            }
            if ($male->calculateMaleHeight() > $altura ){
                $errorMsg = "Aten&ccedil;&atilde;o o texto do Braille em ALTURA n&atilde;o cabe na caixa.";
                $errorMsg .= "<br />";
                $errorMsg .= "Volte atr&aacute;s e tente de novo.";
                $this->view->msg = $errorMsg;
            }

            //Verifica se o cortante está bem definido nos comentários do Optimus
            if (! is_numeric($male->getUnidadesDoCortante())) {
                $errorMsg = "O nome do cortante n&atilde;o est&aacute; definido segundo as regras. Corrija no Optimus e volte a tentar.";
                $errorMsg .= "<br />";
                $errorMsg .= "<b>Ex: </b>CA 03383.01 15 UNID";
                $this->view->msg = $errorMsg;
            } else {
                $priceMale = $male->calculateMalePrice();
                if ($femea == 1) {
                    $priceFemale = $male->firstFemaleCalculation();
                } else {
                    $priceFemale = 0;
                }
                /**
                Testes
                 */
                //$this->view->altura = $altura;
                $this->view->texto = $texto;
                $this->view->getUnidadesdoCortante   = $male->getUnidadesdoCortante();
                $this->view->formatTextforCount      = $male->formatTextforCount();
                $this->view->calculateMaleLenght     = $male->calculateMaleLenght();
                $this->view->calculateMaleHeight     = $male->calculateMaleHeight();
                $this->view->setMaleLenghtFinalValue = $male->setMaleLenghtFinalValue();
                $this->view->setMaleHeightFinalValue = $male->setMaleHeightFinalValue();
                $this->view->getFirstChar            = $male->getFirstChar();
                $this->view->getLastChar             = $male->getLastChar();
                //print_r($male->getFirstChar());
                //print_r($male->checkFirstCharOfAllParagraphs());
                /**
               Fim de teste
                 */
                $braillePrice = new App_User_Service_BrailleValue();
                $braillePrice->insert($obra, $priceMale, $priceFemale);
                $this->view->priceFemale = $priceFemale;
                $this->view->priceMale = $priceMale;
                $this->view->pdfLink = $obra;
            }
        } else {
            // Se o formulário não estiver bem preenchido retorna o formulário com os respectivos erros.
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function braillepdfAction ()
    {
        $this->_helper->layout->disableLayout();
        $obra   = $this->_getParam('obra');
	    $pecas  = $this->_getParam('pecas');
        $params = new App_User_Service_Braille();
        $pdfValues = $params->getAll($obra);
        $male = new App_Calculations_BraillePrice();
        $male->setNumObra($obra);

	    $pecas = (isset($pecas)) ? $pecas : $male->getUnidadesdoCortante();


	    $pdf = new App_PDF_Create(array(
            'obra' => $pdfValues['obra'] ,
            'largura' => $pdfValues['largura'] ,
            'altura' => $pdfValues['altura'] ,
            'femea' => $pdfValues['femea'] ,
            'cortante' => $pdfValues['tipo'] ,
            'texto' => strtolower($pdfValues['texto']),
            'numpecas' =>$pecas,
            ));
        $final = $pdf->getPDF();
        $this->view->pdf = $final;
	    $this->view->name = $pdfValues['obra'];



	   /* $tr = array(
		    'obra' => $pdfValues['obra'] ,
		    'largura' => $pdfValues['largura'] ,
		    'altura' => $pdfValues['altura'] ,
		    'femea' => $pdfValues['femea'] ,
		    'cortante' => $pdfValues['tipo'] ,
		    'texto' => strtolower($pdfValues['texto']),
		    'numpecas' => $male->getUnidadesdoCortante()
	    );

	    print_r($tr);*/


    }

	public function braillepdfdownloadAction ()
	{
		$this->_helper->layout->disableLayout();
		$obra = $this->_getParam('obra');
		$params = new App_User_Service_Braille();
		$pdfValues = $params->getAll($obra);
		$male = new App_Calculations_BraillePrice();
		$male->setNumObra($obra);
		$pdf = new App_PDF_Create(array(
			'obra' => $pdfValues['obra'] ,
			'largura' => $pdfValues['largura'] ,
			'altura' => $pdfValues['altura'] ,
			'femea' => $pdfValues['femea'] ,
			'cortante' => $pdfValues['tipo'] ,
			'texto' => strtolower($pdfValues['texto']),
			'numpecas' => $male->getUnidadesdoCortante()
		));
		$final = $pdf->getPDF();
		$this->view->pdf = $final;
		$this->view->name = $pdfValues['obra'];
	}

    public function femeaAction ()
    {

	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
        $this->view->form =  new App_Forms_BrailleFemea();
    }

    public function femeacreateAction ()
    {
        
        $form = new App_Forms_BrailleFemea();
        if ($form->isValid($_POST)) {
            $braille = new App_Auxiliar_GenerateFemaleBraille(
                $this->_request->getPost('altura') , 
                $this->_request->getPost('largura') ,
                $this->_request->getPost('cortante'),
                $this->_request->getPost('qtd'));
                
                $values = $braille->create();
                
                $this->view->values = $values;
               
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }
    public function provaAction()
    {
	    $this->_helper->layout()->setLayout('layout-iso-bootstrap');
	    $form = new App_Forms_BrailleProva();
	    $this->view->formBrailleProva = $form;
    }
    
    public function provacreateAction()
    {
        $form = new App_Forms_BrailleProva();

            if ($form->isValid($_POST)) {
                $this->_helper->layout->disableLayout();
                $filterValues = new Zend_Filter_StripTags();
                $texto = $filterValues->filter($this->_request->getPost('texto'));

	            $pdf = new App_PDF_CreateBrailleProva(array('texto' => $texto));
                $this->view->pdf = $pdf->createPDF();
                
        } else {
            //passa as mensagem de erro e o formul�rio para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }
}
