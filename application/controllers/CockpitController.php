<?php

class CockpitController extends Zend_Controller_Action
{


    protected $optimus;

    protected $job;

    protected $cortantes;

    protected $chapas;

    protected $qualidade;

    protected $ocorrencias;



    public function init ()
    {

        $this->optimus = new App_User_Service_Optimus();
        $this->job = new App_User_Service_Obras();
        $this->cortantes = new App_User_Service_Cortantes();
        $this->chapas = new chapasrec();
        $this->qualidade = new qualidadeModel();
        $this->ocorrencias = new App_User_Service_RegistosOcorrencias();
    }

    public function indexAction ()
    {

        $form = App_Forms_Cockpit::getForm();
        $this->view->form = $form;
    }

    public function errorAction ()
    {
}

    public function displayAction ()
    {

        
        $form = App_Forms_Cockpit::getForm();
        if ($form->isValid($_POST)) {
            $this->_helper->layout()->setLayout('layout-iso');
            
            $filterValues = new Zend_Filter_StripTags();
            $numobra = $filterValues->filter($this->_request->getPost('numobra'));
            $checkJN = New App_Auxiliar_CheckJobNumber();
            $checkJN->setJobNumber($numobra);
            if ($checkJN->check() == 0) {
                $this->redirect('/cockpit/error');
            } else {
                
                $this->redirect('/cockpit/preview/' . $numobra);
            } 
                
        } else {
            //passa as mensagem de erro e o formulário para a VIEW
            $this->view->errors = $form->getMessages();
            $this->view->form = $form;
        }
    }

    public function previewAction ()
    {

        $this->_helper->layout()->setLayout('layout-iso');
        $numobra = $this->_getParam('obra');
        $checkJN = New App_Auxiliar_CheckJobNumber();
        $checkJN->setJobNumber($numobra);
        
        if ($checkJN->check() == 0) {
            $this->_redirect('/cockpit/error');
        } else {
            $values = $this->job->getValues($numobra);
            $params = array(
                'numobra' => $numobra , 
                'cliente' => $values['cliente'] , 
                'produto' => $values['produto'] , 
                'formato' => $values['formato'] , 
                'edicao' => $values['edicao'] , 
                'cartolina' => $values['cartolina'] , 
                'espessura' => $values['espessura'] , 
                'codproduto' => $values['codproduto'] , 
                'codlaetus' => $values['codlaetus'] , 
                'codvisual' => $values['codvisual'] , 
                'codf3' => $values['codf3'] , 
                'numcores' => $values['numcores'] , 
                'vernizmaq' => $this->translateCheckboxes($values['vernizmaq']) , 
                'vernizuv' => $this->translateCheckboxes($values['vernizuv']) , 
                'braille' => $this->translateCheckboxes($values['braille']) , 
                'prova' => $values['prova']);
            $this->view->job = $params;
            
        /**
         * Qualidade
         */
        $this->view->qualidade = $this->qualidade->getAllRecords($values['cliente']);
        }
        switch ($values['numcores']) {
            case ("CMYK"):
                $obraCores = array(
                    "C" , 
                    "M" , 
                    "Y" , 
                    "K");
                break;
            default:
                $obraCores = explode('+', $values['numcores']);
                break;
        }
        $sql = new App_User_Service_Pantones();
        $allColors = array();
        foreach ($obraCores as $cores) {
            $cor = $sql->getHexColor($cores);
            $allColors[] = '<div id="box" style="background-color:' . $cor['hex'] . ';">&nbsp;</div>';
        }
        $this->view->colors = array_combine($obraCores, $allColors);
        $path = new App_User_Service_Backstage();
        $backstageInfo = $path->getValuesSubOrderID($numobra);
        if (empty($backstageInfo['Url']) || $backstageInfo['SubOrderId'] != $numobra) {
            $backstageInfo = $path->getValuesProjectID($numobra);
        }
        $cleanPath = str_replace('file://fertbs1/Scope_Laboratorios/', '', $backstageInfo['Url']);
        $braille = new App_User_Service_BrailleValue();
        $braillePrice = $braille->getAll($numobra);
        $this->view->priceFemale = $braillePrice['preco_femea'];
        $this->view->priceMale = $braillePrice['preco_macho'];
        $this->view->pdfLink = $numobra;
        $this->view->masterPath = $backstageInfo['Url'];
        $this->view->path = $cleanPath;
        $this->view->formatoCartolina = $backstageInfo['Category3'];
        $cleanPath2 = str_replace('file://fertbs1/Scope_Laboratorios/', '/media/scope/', $backstageInfo['Url']);
        $this->view->cleanPath2 = $cleanPath2;
        /**
         * Cortantes
         */
        $cortante     = $this->optimus->getJobComments($numobra);
        $linhaOptimus = $cortante['subject'];
        $codCortanteOptimus = substr($linhaOptimus, 2, 6);
        $codCortante = (int) $codCortanteOptimus;
        $this->view->resultsCortantes = $this->cortantes->searchByCode($codCortante);
        //
        /**
         * 
         *Fim Cortantes
         */
        $registos = new App_User_Service_Registos();
        if (empty($values['codf3'])) {
            $data = $registos->getNumObra($numobra);
            $codinterno = $registos->getCodInterno($data['cod_interno']);
            $chapas = new App_User_Service_ArqChapas();
            $arquivo = $chapas->getChapas($data['cod_interno']);
            $this->view->arquivo = $arquivo;
            $this->view->registos = $codinterno;
        } else {
            $data = $registos->getCodInterno($values['codf3']);
            $chapas = new App_User_Service_ArqChapas();
            $arquivo = $chapas->getChapas($values['codf3']);
            $this->view->arquivo = $arquivo;
            $this->view->registos = $data;
        }
        //Braille Tamanho
        $brailleTable = new App_User_Service_Braille();
        $brailleMaleSize = $brailleTable->getAll($numobra);
        $this->view->brailleMaleSize = $brailleMaleSize;
        $producao = $this->optimus->getAllStagesOfJob($numobra);
        $this->view->producao = $producao;
        $entregas = $this->optimus->getDeliveries($numobra);
        $this->view->entregas = $entregas;
        /**
         * Generic Query Job table
         */
        $getJobParameters = $this->optimus->genericQuery("select * from `job` where `j_number` = '$numobra'");
        $this->view->jobParameters = $getJobParameters;
        /**
         * Chapas recuperadas
         */
        $sql = $this->chapas->getRecordByJobNumber($numobra);
        
        $this->view->chapasrec = $sql;
        /**
         * Ocorrencias
         */
        
        $this->view->ocorrencias = $this->ocorrencias->getValues($numobra);
        
        
    }

    public function undefinedAction ()
    {

        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
    }

   

    /**
     * 
     * Transforma Sim ou Não em 0 ou 1
     * @param string $value
     * @return int
     */
    private function translateCheckboxes ($value)
    {

        $number = ($value == 'Sim') ? 1 : 0;
        return $number;
    }

    /**
     * Transforma 0 ou 1 Sim ou Não
     * @param int $value
     * @return string
     */
    private function reverseTranslateCheckboxes ($value)
    {

        $string = ($value == 0) ? 'Não' : 'Sim';
        return $string;
    }
}