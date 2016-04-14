<?php
/**
 * Created by PhpStorm.
 * User: rpsimao
 * Date: 17/06/14
 * Time: 10:55
 */

class App_View_Helper_Title {


	public function Title(){


		$cName = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		
		switch ($cName) {
			case "producao":
				return "Obras em Produ&ccedil;&atilde;o"; 
				break;
			case "selo":
				return "Selo Provas"; 
				break;
			case "obra":
				return "Informa&ccedil;&atilde;o Obras"; 
				break;
			case "emprova":
				return "Obras em Prova"; 
				break;
			case "braille":
				return "Braille"; 
				break;
			case "laetus":
				return "C&oacute;digo Laetus"; 
				break;
			case "cockpit":
				return "Informa&ccedil;&atilde;o Obras"; 
				break;
			case "tolerancias":
				return "Toler&acirc;ncias"; 
				break;
			case "labs":
				return "Registos"; 
				break;
			case "arqchapas":
				return "Arquivo Chapas"; 
				break;
			case "labshome":
				return "Laborat&oacute;rios"; 
				break;
			case "cliches":
				return "Clich&eacute;s"; 
				break;
			case "cortantes":
				return "Arquivo Cortantes"; 
				break;
			case "entregas":
				return "Obras Entregues M&ecirc;s " . date('m'); 
				break;
			case "arqbraille":
				return "Arquivo de Brailles";
				break;
			case "diecuts":
				return "Arquivo de Cortantes";
				break;
			default:
				echo 'F3 Embalagem DB';
				break;
		}


	}


} 