<?php

/**
 * Controller para mostrar a espessura da cartolina consoante o valor escolhido na Form
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * @see App_Forms_Obra
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class AjaxController extends Zend_Controller_Action
{

	private $optimus;

	public function init ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

	    $this->optimus   = new App_User_Service_Optimus();
	    $this->provas    = new EmprovaTable();
	    $this->laetus    = new App_User_Service_Laetus();
	    $this->pruebas   = new App_User_Service_OptimusPruebas();
	    $this->cortantes = new App_User_Service_Cortantes();
	    $this->braille   = new App_User_Service_Braille();


    }

	public function sendmailtosiopaAction(){



}

	public function updatearqbraillelabsAction()
	{

		$id = $this->_getParam('id');
		$optimus = $this->_getParam('optimus');
		$shortname = $this->_getParam('shortname');

		$db = new ArqbraillesLabsTable();
		$db->updateLabs($id, $optimus, $shortname);

	}

	public function deletearqbraillelabsAction()
	{

		$id = $this->_getParam('id');


		$db = new ArqbraillesLabsTable();
		$db->deleteLabs($id);

	}

	public function refreshcustomersforarqbrailleslabsindexAction(){

		$id = $this->_getParam('id');
		$db = new ArqbraillesLabsTable();
		$row = $db->find($id)->toArray();


		$this->getResponse()->appendBody(Zend_Json_Encoder::encode(array('id'=>$row[0]["id"], 'optimus'=>$row[0]['optimus'], 'shortname'=>$row[0]['shortname'])));
	}

	public function getcustomersforarqbrailleslabsindexAction(){



		$db = $this->optimus->gelAllLabsCustomers()->toArray();
		$id = $this->_getParam('id');
		$lab = $this->_getParam('lab');

		$labs = new App_Auxiliar_LabCustomersToSelect($db);
		$select = $labs->buildSelect($id, $lab);

		$this->getResponse()->appendBody($select);




	}

	public function createbrailleAction(){

		$id = $this->_getParam('id');


			$job = new App_User_Service_Obras();

			$db = new Arqbrailles();
			$values = $db->findById($id);

			if (strlen($values['obras'] > 5)) {

				$obras =  explode(",", $values['obras']);

				$jobs = array_reverse($obras);

				$finalJob = $jobs[0];

				if ($finalJob == null) {

					$finalJob = $jobs[1];
				}

				$selo = $job->getValues($jobs[0]);

				$medidas = explode("x", $selo['formato']);

			} else {

				$finalJob = $values['obras'];
			}

			$male = new App_Calculations_BraillePrice();
			$male->setNumObra($finalJob);
			$male->setTexto(utf8_encode($values['txtbraille']));
			//$precoMacho = $male->calculateMalePrice();


			$precos = new App_User_Service_BrailleValue();
			$precoFinal = $precos->getAll($values['obras']);



			$codF3 = $values['codf3'];
			$check = substr($codF3, 0, 3);

			$finalF3code = ($check == "FT_") ? $values['codf3'] : "FT_".$values['codf3'];



			$txt = $values['b1']." machos para leitura braille" ."\r\n
	BRAILLE: ".$values['nbraille_lab']."-".App_Auxiliar_AddZero::num($values['nbraille_num'])."-".App_Auxiliar_AddZero::month($values['nbraille_mes'])."-".App_Auxiliar_AddZero::month($values['nbraille_ano'])."
	NUMERO A INSERIR NA PLACA DE BRAILLE: ".App_Auxiliar_AddZero::num($values['nbraille_num'])."\r\n"
		.$finalF3code."
	R.:".$finalJob . "\r\n". "\r\n". "Condições de Pagamento: crédito a 120 dias (ao final do mês.)";



		$precos = new App_User_Service_BrailleValue();
		$precoFinal = $precos->getAll($finalJob);

		$text = stripcslashes(strtolower($values['txtbraille']));
		$numberOfLines = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);


		foreach ($numberOfLines as $chars)
		{
			$numberoschars = strlen($chars);

			$final[] = $numberoschars;

		}

		$biggestline = max($final);
		$image = new App_Auxiliar_CreateImage();
		$image->setChars($biggestline);
		$image->setArrayOfText($numberOfLines);
		$image->setText($values['txtbraille']);
		$image->setBrailleFlag(TRUE);


			$values = array(

				'pecas'          => $values['b1'],
				'numobra'        => $finalJob,
				'texto'          => utf8_encode($values['txtbraille']),
				'femeaLrg'       => str_replace(" ", "", $medidas[2]),
				'femeaAlt'       => str_replace(" ", "", $medidas[0]),
				'textoOptimus'   => $txt,
				'preco'          => number_format($precoFinal['preco_macho'],2),
				'linhas'         => $male->calculateMaleHeight(),
				"imagem"         => $image->renderbase64()
			);

		$this->getResponse()->appendBody(Zend_Json_Encoder::encode($values));



		}

	public function validatejobforbraillepdfAction(){

		$job = $this->_getParam('job');

		$config = Zend_Registry::get('optimus');
		$dbOptimus = Zend_Db::factory($config->database);
		$validateJobOptimus = new Zend_Validate_Db_RecordExists(array('table'=>'job', 'field'=>'j_number','adapter'=>$dbOptimus));

		$jobData = new App_User_Service_Optimus();

		$prepForBraille = ($jobData->getJobComments($job)) ? True : false;


		$this->getResponse()->appendBody(Zend_Json_Encoder::encode(
			array(
				'optimus'=>$validateJobOptimus->isValid($job),
				'braille'=>$prepForBraille


			)));

	}

	public function braillepricesimulationAction(){}

	public function femeabraillepricesimulationAction(){}

	public function updatearqbraillereppecasAction(){


		$values = $this->getAllParams();

		$db = new ArqBraillesRep();

		try {
		$db->updatePecas(array("id"=>$values['id'],
		                       "pecas"=>$values['a1'],
		                       "data"=>$values['a2'],
		                       'oxidacao'=>$values['a3'],
							   'partidos'=>$values['a4'],
							   'esmagados'=>$values['a5'],
							   'novo'=>$values['a6']
		));
			$this->getResponse()->appendBody(1);

		} catch(Exception $e) {

			$this->getResponse()->appendBody($e->getMessage());

		}



	}

	public function removearqbraillereppecasAction(){


		$values = $this->getAllParams();

		$db = new ArqBraillesRep();

		try {
			$db->deletePecas($values['id']);

			$this->getResponse()->appendBody(1);

		} catch(Exception $e) {

			$this->getResponse()->appendBody($e->getMessage());

		}



	}

	public function braillefemeapricesimulationvalidateAction(){


		$values = $this->getAllParams();


		$braille = new App_Auxiliar_GenerateFemaleBraille(
			$values['altura'] ,
			$values['largura'] ,
			$values['cortante'],
			$values['qtd']);

		$values = $braille->create();


		for ($index = 0; $index < $values[0]; $index ++) {
			$numberOfLines[] = $index;
		}
		$numberOfPara = count($numberOfLines);
		$numberOfChars = str_repeat('é', $values[1]);
		$image = new App_Auxiliar_CreateImage();
		$image->setChars($values[1]);
		$image->setArrayOfText($numberOfLines);
		$image->setText(str_repeat($numberOfChars . "\r\n", $numberOfPara));
		$image->setBrailleFlag(TRUE);



		$output = array("linhas" => $values[0], 'caracteres' => $values[1], 'preco' => $values[2], 'qtd' => $values[3], "imagem"=> $image->renderbase64());

		$this->getResponse()->appendBody(Zend_Json_Encoder::encode($output));



	}

	public function braillepricesimulationvalidateAction()
	{

		$values = $this->getAllParams();

		$male = new App_Calculations_BraillePriceSimulation();

		if ($male->checkLastCharOfTextArea($values['texto']) == 0) {

			$this->getResponse()->appendBody(1);
		}

		else if ($male->checkSecondLastCharOfTextArea($values['texto']) == 0) {

			$this->getResponse()->appendBody(2);
		} else {

			$male->setTexto($values['texto']);
			$male->setUnidadesDoCortante($values['placas']);
			$priceMale = $male->calculateMalePrice();

			$text = stripcslashes(strtolower($values['texto']));
			$numberOfLines = preg_split('/\n/', $text, - 1, PREG_SPLIT_NO_EMPTY);


			foreach ($numberOfLines as $chars)
			{
				$numberoschars = strlen($chars);

				$final[] = $numberoschars;

			}

			$biggestline = max($final);
			$image = new App_Auxiliar_CreateImage();
			$image->setChars($biggestline);
			$image->setArrayOfText($numberOfLines);
			$image->setText($values['texto']);
			$image->setBrailleFlag(TRUE);

			$array = array("imagem" => $image->renderbase64(), 'preco' => $priceMale);

			$this->getResponse()->appendBody(Zend_Json_Encoder::encode($array));
		}

	}

    public function getcurrentbraillepriceAction()
    {
        
        $braillePrice = $this->braille->getMalePrice();

        $price = array("price"=>$braillePrice);

        $this->getResponse()->appendBody(Zend_Json_Encoder::encode($price));
        
    }

    public function updatecurrentbraillepriceAction()
    {
        
        $val = $this->_getParam('v');
        $price = str_replace(",", ".", $val);
        $this->braille->updateMalePrice($price);
        
    }
    
    public function indexAction ()
    {

        // action body
    }

    public function checkjobnumberembdbAction()
    {
        $numobra = $this->_getParam('job');
        $checkJN = New App_Auxiliar_CheckJobNumber();
        $checkJN->setJobNumber($numobra);
        $result = $checkJN->check();
        $this->getResponse()->appendBody($result);
    }

    public function espessuraAction ()
    {
        $action = $this->_getParam('num');
        $action = explode("-", $action);
        $action1 = str_replace('g', "", $action[1]);
        $espessura = new App_User_Service_Cartolina();
        $result = $espessura->getEspessura($action[0], $action1);
        $this->getResponse()->appendBody($result['espessura']);
    }

    public function obraoptimusAction ()
    {
        $numobra = $this->_getParam('num');
        $jobData1 = $this->optimus->getJobInfo1($numobra);
        $jobData2 = $this->optimus->getJobInfo2($numobra);
        $this->getResponse()->appendBody('<h1>Dados Folha Obra</h1>
        <textarea rows="10" cols="30">' . htmlentities($jobData1['sect_text']) . '</textarea>
        <textarea rows="10" cols="30">' . htmlentities($jobData2['sect_text']) . '</textarea>');
    }

    public function registosAction ()
    {
        $action = $this->_getParam('codcliente');
        $registos = new App_User_Service_Jobsdefversion();
        $getAll = $registos->getCodInterno($action);
        $i = 1;
        $color = new App_Styles_RowColor();
        $color->setColors('white', '#eff9fe');
        echo '<table id="the-table"><tr><th>C√≥d.<br />Interno</th><th>C√≥d.<br />Cliente</th><th>N¬∫<br />Vers√£o</th><th>N¬∫<br />Edi√ß√£o</th><th>Data</th><th>N¬∫<br />Obra</th>';
        echo '<th>Editar</th><th>Apagar</th></tr>';
        foreach ($getAll as $data) {
            echo '<tr bgcolor="' . $color->display($i) . '">';
            echo '<td>' . $data['codinterno'] . '</td>';
            echo '<td>' . $data['codcliente'] . '</td>';
            echo '<td>' . $data['numversao'] . '</td>';
            echo '<td>' . $data['numedicao'] . '</td>';
            echo '<td>' . $data['data'] . '</td>';
            echo '<td>' . $data['registo'] . '</td>';
            echo '<td><a href="/registos/edit/' . $data['id'] . '">Editar</a></td>';
            echo '<td><a href="JavaScript:confirm_delete_record(' . $data['codinterno'] . ',' . $data['id'] . ');" style="color: #d91213;">Apagar</a></td>';
            echo '</tr>';
            $i ++;
        }
        echo '</table></div>';
    }

    public function provaprepressAction ()
    {
        $id = $this->_getParam('id');
        $this->provas->updateProva($id, 1);
    }

    public function provadeptecAction ()
    {
        $id = $this->_getParam('id');
        $this->provas->updateDepTec($id, 2);
    }

    public function handleimagesAction ()
    {
        $rawPath = $this->_getParam('path');
        $path = str_replace("::", "/", $rawPath);
        $deg = $this->_getParam('deg');
        $obra = $this->_getParam('obra');
        $preview = new App_Files_CreateImages();
        $preview->setPath($path);
        $preview->rotateImages($deg);
        echo '<img src="http://intranet.fterceiro.pt/media/scope/' . $path . '/temp/preview.jpg" />';
    }

    public function deleteimagesAction ()
    {
        $rawPath = $this->_getParam('path');
        $path = str_replace("::", "/", $rawPath);
        $obra = $this->_getParam('obra');
        $preview = new App_Files_CreateImages();
        $preview->setPath($path);
        $preview->deleteImages();
        echo '<img src="/imagens/nopreview.jpg" />';
    }

    public function medidascortanteAction ()
    {

        $cortanteNumber = $this->_getParam('id');
        
        $sql = $this->laetus->getMeasuresByCortanteNumberAjaxCall($cortanteNumber);
       
        $this->getResponse()->appendBody($sql['formato'] . "x" . $sql['laboratorio']);
       
    }

    public function laboratorionameAction ()
    {

        $cortanteNumber = $this->_getParam('id');
        if ($cortanteNumber == null) {
            $cortanteNumber = 0;
        }
        
        $sql = $this->laetus->getMeasuresByCortanteNumberAjaxCall($cortanteNumber);
        if ($cortanteNumber != 0) {
            $this->getResponse()->appendBody('<input type="text" name="laboratorio" id="laboratorio" value="' . $sql['laboratorio'] . '" class="rounded-textbox_medium" />');
        } else {
            $this->getResponse()->appendBody('<input type="text" name="laboratorio" id="laboratorio" value="" class="rounded-textbox_medium" />');
        }
    }
    
    public function cortantesexecucaoAction()
    {
        $this->modelCortantesExecucao = new App_User_Service_CortantesExecucao();
        $id = $this->_getParam('id');
        $sql = $this->modelCortantesExecucao->update(array('id'=>$id, 'dataentrega'=>date('Y-m-d'),  'entregue' =>TRUE));
    }
    
    public function insertcortantefolhaobraAction()
    {
        $params = $this->getAllParams();
        
        if (is_numeric($params['j_ucode2']))
        {
            $measures = $this->cortantes->getMeasuresByCortanteNumber($params['j_ucode2']);
            
            $exec = $this->optimus->insertCortanteFolhaObra($params['j_ucode2'], $params['j_number'], $measures, $code['estante']);
            
            $msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";
            
            $this->getResponse()->appendBody($msg);
        } else {
            $this->insertcortantenamefolhaobraAction();
        }
    }

    public function insertcortantenamefolhaobraAction()
    {
        $params = $this->getAllParams();
    
        $code = $this->cortantes->searchByCortanteName($params['j_ucode2']);
        
        $measures = $this->cortantes->getMeasuresByCortanteNumber($code['codigo']);
    
        $exec = $this->optimus->insertCortanteFolhaObra($params['j_ucode2'], $params['j_number'], $measures, $code['estante']);
    
        $msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";
    
        $this->getResponse()->appendBody($msg);
    }
    
    public function removecortantefolhaobraAction()
    {
        $params = $this->getAllParams();
        
        $exec = $this->optimus->removeCortanteFolhaObra($params['j_number']);
        
        $msg = ($exec == "OK" ) ? "Response:OK" : "Response:NO:OK";
        
        $this->getResponse()->appendBody($msg);
    }
    
    public function getcortanteforviewAction()
    {
        $cortanteNumber = $this->_getParam('id');
        $exec = $this->cortantes->getSingleArchiveJSON($cortanteNumber);
        $this->getResponse()->appendBody($exec);
        
    }

    public function chapasrecuperadasclienteAction()
    {
       $cliente = $this->_getParam('cli');
       $db = new chapasrec();
       $exec = $db->sumChapasByClient($cliente);

	   $json = Zend_Json::encode($exec);
       
       $this->getResponse()->appendBody($json);
    }

    public function cartelasAction()
    {
        $codigo = $this->_getParam('cod');
        $table = new App_User_Service_Cartelas();
        $data = $table->getSingleArchive($codigo);
        $db = new App_User_Service_Cartelasobras();
        $res = $db->getAllByBarcode($codigo);
        foreach ($res as $value) {
            $obra[] = $value['obra'];
        }
        
        if (!empty($obra)) 
        {
            $obras = implode(',', $obra);
            $obras = str_replace(',', ', ', $obras);;
        } else {
            $obras = null;
        }
        
        
        
        $cod = substr($codigo, 0, -1);
        
                
        $barcodeOptions = array('text' => $cod);
        
        $bc = Zend_Barcode::factory('ean13','image',$barcodeOptions,array());
        /* @var $bc Zend_Barcode */
        $res = $bc->draw();
        
        
        ob_start();
        imagepng($res);
        $contents = ob_get_contents();
        ob_end_clean();
        $res = base64_encode($contents);
        
        $image = array('image' => $res);
        $obras = array('obras'=> $obras);
        $data = array_merge($data, $image);
        $data = array_merge($data, $obras);
        
        $logger = Zend_Registry::get('logger');
        $logger->log($data, Zend_Log::INFO);
        
        $exec = Zend_Json::encode($data);
        $this->getResponse()->appendBody($exec);
        
        
        
        
        
    }
    
    public function cartelassearchAction() 
    {
        $cods = array();
        $codigo = $this->_getParam('term');
        $table = new App_User_Service_Cartelas();
        $data = $table->getAllByBarcodeLike($codigo);
        foreach ($data as $value)
        {
           $cods[] = array("value" => $value['codbarras'], 'nome'=>utf8_encode($value['nome'])); 
        }
        $exec = Zend_Json::encode($cods);
        $this->getResponse()->appendBody($exec);
    }
    
    public function cartelassearchnomeAction()
    {
        $this->view->setEscape('stripslashes');
        $cods = array();
        $codigo = $this->_getParam('term');
        $table = new App_User_Service_Cartelas();
        $data = $table->getAllByNameLike($codigo);
        foreach ($data as $value)
        {
            $cods[] = array("value" => utf8_encode($value['nome']), 'cod'=>$value['codbarras']);
        }
        $exec = Zend_Json::encode($cods);
        $this->getResponse()->appendBody($exec);
    }
    
    public function cartelastooptimusAction()
    {
        $data = $this->getAllParams();
        $j_number = $data['nobra'];
        $j_ucode10 = substr($data['addoptimus'], 0, -1);
        $db = new App_User_Service_Optimus();
        
        /*$data = explode(',', $j_ucode10);
        $data = implode(',', array_unique($data));*/
        
        $exec = $db->insertCaixas($j_number, $j_ucode10);
        
        $db1 = new App_User_Service_Cartelasobras();
        
        $removeChars = preg_replace('/[a-zA-Z-]/', '', $j_ucode10);
        $removeChars = str_replace(' ', '', $removeChars);
        $toArray = explode(',', $removeChars);
        
        
        foreach ($toArray as $value) 
        {
            $db1->insertData(array('barcode' => $value, 'obra'=>$j_number));
        }
        
        $this->getResponse()->appendBody($exec);
    }
    
    public function checkobraoptimusAction()
    {
        $obra = $this->_getParam('obra');
        $db = new App_User_Service_Optimus();
        $exec = $db->checkObra($obra);
        $rowCount = count($exec);
        
        if ($rowCount <= 0)
        {
            $a = array('e' => 'noobra');
            $exec = Zend_Json::encode($a);
        } else {
            $a = array('e' => 'OK');
            $exec = Zend_Json::encode($a);
        }
        $this->getResponse()->appendBody($exec);
    }

    public function cleandataAction()
    {
        $data = $this->_getParam('data');
        $data = explode(',', $data);
        $data = implode(',', array_unique($data));
        $this->getResponse()->appendBody($data);
        
        $logger = Zend_Registry::get('logger');
        $logger->log($data, Zend_Log::INFO);
    }
    
    public function txtbrailleAction()
    {
        $param = $this->_getParam('txt');
        
        $db = new App_User_Service_Braille();
        $data = $db->searchTxt($param);
        $count = count($data->toArray());
        
        if ($count > 0) {

	    $resp = '<p class="text-info"><i class="fa fa-check-square-o"></i>&nbsp;Existem ' . $count . ' registos iguais ou similares.</p><br></div>';
	    $resp.= '<table class="table table-striped table-bordered table-hover"><thead><tr><th>Obra</th><th>Texto</th></tr></thead><tbody>';
        
        foreach ($data as $value) {
            $resp.= '<tr><td><a href="/cockpit/preview/'.$value['obra'].'">' . $value['obra'] . '</a></td><td>' . utf8_encode($value['texto']) . '</td></tr>';
            //$resp.= '<tr><td>' . $value['obra'] . '</td><td>' . utf8_encode($value['texto']) . '</td></tr>';
        }
        
            $resp.= "</tbody></table>";
        } else {
            
            $resp = '<p class="braille-none">Não foram encontrados registos iguais ou similares.</p>';
        }
        
        
        $this->getResponse()->appendBody($resp);
        
        
        
    }
    
    public function rettxtbrailleAction()
    {
        $id = $this->_getParam('id');
        
        $config2 = Zend_Registry::get('embalagem');
        $db2     = Zend_Db::factory($config2->database);
        
        $emb = new Zend_Validate_Db_RecordExists(array(
                'table' => 'arqbrailles' ,
                'field' => 'nbraille_num' ,
                'adapter' => $db2));
        $emblab = $emb->isValid($id);
        
        if ($emblab == false) {
           
            $this->getResponse()->appendBody("");
        } else {
            
            $db = new Arqbrailles();
            $vals = $db->findById($id);
            
            
            $this->getResponse()->appendBody(Zend_Json_Encoder::encode(array('txtbraille'=>utf8_encode($vals['txtbraille']), 'obs' => utf8_encode($vals['obs']))));
        }
        
        
        
    }

    public function checkcodf3Action()
    {
        $codf3 = $this->_getParam('codf3');
        
        if ($codf3 != null && strlen($codf3) >= 7){
        
        $db = new Arqbrailles();

	        $cods = $db->getByCodF3($codf3);

	        if (count($cods) > 0){

	            $codigos = "Este código já existe no Braille: ";

	            foreach ($cods as $cod)
	                {

	                    $codigos.= $cod["nbraille_num"] . ", ";
	                }

	            $txt = substr($codigos, 0, -2);

	            $this->getResponse()->appendBody($txt);
	        }
        }
    }
    
    public function getsizeofcartonAction()
    {
        
        $job      = $this->_getParam('job');
        $db       = new App_User_Service_Optimus();
        $jobData  = $db->getJobInfo1($job);
        $comments = $db->getJobComments($job);
        
        /*$ccc = preg_match("[^CA]i", $comments['subject'], $match);
        
        if ($match[0] == null) 
        {
          $ccc = preg_match("[^CC]i", $comments['subject'], $match);
        }*/
        
        $corte = substr($comments['subject'], 0,2);
        
        switch ($corte) {
            case "CA":
                $tipo = "autoplatina";
            break;
            
            case "CC":
                $tipo = "cilindrica";
                break;
            
            default:
                $tipo = null;
            break;
        }
        
        
        $stringSearch = new App_Calculations_StringSearch();
        $stringSearch->setContents($jobData['sect_text']);
        
        
         
        $stringSearch->setString1('Formato fechado: ');
        $stringSearch->setString2('mm.');
        $formato = $stringSearch->regExpSearch();
        $formato = str_replace(" ", "", $formato);
        
        $medidas = explode("*", $formato);
        
        @$result = array("y" => $medidas[0], "x" => $medidas[2] ,'tipo' => $tipo, "comentarios" => $comments['subject'], "person" => ucfirst($comments['user']), 'revisao' => $comments['lastrev']);
        
        if ($medidas[0] == "" || $medidas[2] == null)
        {
	        $json = Zend_Json_Encoder::encode(array("code"=>404));
			$this->getResponse()->appendBody($json);

        } else {

	        $json = Zend_Json_Encoder::encode($result);
			$this->getResponse()->appendBody($json);

        }



        
    }
    
    public function getf3codeAction()
    {
        $numobra = $this->_getParam('job');
        $optimus = new App_User_Service_Optimus();
        $jobData2 = $optimus->getJobInfo2($numobra);
        
        
        $stringSearch = new App_Calculations_StringSearch();
        $stringSearch->setContents($jobData2['sect_text']);
        
        
        $stringSearch->setString1('FT_');
        $stringSearch->setString2('/');
        $codf3 = $stringSearch->search();
        
        if (!preg_match("/FT_/", $codf3))
        {
            $stringSearch->setString1('Cod.FT:');
            $stringSearch->setString2('/');
            $codf3 = $stringSearch->search();
            $codf3 = ereg_replace("[^0-9]", "", $codf3 );
            $codf3 = substr($codf3, 0, 7);
        }
        
        
        if (strlen($codf3) > 10)
        {
            $codf3 = ereg_replace("[^0-9]", "", $codf3 );
            $codf3 = substr($codf3, 0, 7);
        
            if (!is_numeric($codf3))
            {
                $codf3 = substr($codf3, 0, 7);
        
                if (!is_numeric($codf3)) { $codf3 = ""; }
        
            }
        }
        
        $this->getResponse()->appendBody($codf3);
        
    }

    public function checkf3codeAction()
    {
        
        $numobra = $this->_getParam('job');
        //$f3code = $this->_getParam('code');
        $optimus = new App_User_Service_Optimus();
        $jobData2 = $optimus->getJobInfo2($numobra);
        
        
        /*$stringSearch = new App_Calculations_StringSearch();
        $stringSearch->setContents($jobData2['sect_text']);
        
        
        $stringSearch->setString1('FT_');
        $stringSearch->setString2('/');
        $codf3 = $stringSearch->search();
        
        if (!preg_match("/FT_/", $codf3))
        {
            $stringSearch->setString1('Cod.FT:');
            $stringSearch->setString2('/');
            $codf3Raw = $stringSearch->search();
            $codf3 = preg_replace("/[^A-Za-z0-9 ]/", '', $codf3Raw);


            if (strlen($codf3) > 10)
            {
                $codf3 = explode(" ", $codf3);

                if ($codf3[0] < 3)
                {
                    $codf3 = str_replace("FT", "", $codf3[1]);

                } else {

                    $codf3 = str_replace("FT", "", $codf3[0]);

                }
            }

            $codf3 = (!is_numeric($codf3)) ? str_replace("FT", "", $codf3) : $codf3;*/
        
        
            //$finalCode = ($f3code != $codf3) ? $co


        /**
         * NOVO algoritmo para sacar o Cod F3
         */

        $subject = $jobData2['sect_text'];

        $pattern1 = '/FT_[A-Za-z0-9]+/';
        $pattern2 = '/FT:[A-Za-z0-9 ]+/i';


        preg_match($pattern1, $subject, $matches);


        $result = ($matches) ? substr($matches[0], 0, 3) : null;


        switch ($result) {
            case 'FT_':
                $codf3 = str_ireplace("FT_", "", $matches[0]);

                break;


            case null:

                preg_match($pattern2, $subject, $matches);

                if ($matches)
                {
                    $codf3 = str_ireplace("FT:", "", $matches[0]);
                    $codf3 = str_replace(" ", "", $codf3);
                } else {
                    $codf3 =  null;
                }
                break;

            default:
                $codf3 =  null;
                break;
        }

        
            $this->getResponse()->appendBody($codf3);
        
        
        }

	public function precobrailleallowedAction()
	{

		$passwd = $this->_getParam('passwd');

		$db = new App_User_Service_Passwords();
		$val = $db->check($passwd);

		$this->getResponse()->appendBody(Zend_Json_Encoder::encode(array("flag"=> $val['precobraille'])));

	}
    
}
