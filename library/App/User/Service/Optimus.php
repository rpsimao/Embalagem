<?php

/**
 * Classe para efectuar pedidos á tabela cartolinas da base de dados optimus (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */
class App_User_Service_Optimus extends App_Master_DB_Optimus
{


	protected $job;
	protected $jtx;
	protected $del;
	protected $tm;
	protected $staff;
	protected $act;
	protected $itm;
	protected $cu;


	/**
	 * Define tables to use
	 */
    function __construct ()
    {
        parent::__construct();
        $this->job     = new JobTable();
        $this->jtx     = new JtxTable();
        $this->del     = new DelTable();
        $this->tm      = new TmTable();
        $this->staff   = new StafTable();
        $this->act     = new ActTable();
        $this->itm     = new ItmTable();
        $this->cu      = new CUTable();
    }


	/**
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function gelAllLabsCustomers()
	{

		$sql = $this->job->select('j_customer');
		$sql->where("j_type like '06%'");
		$sql->group('j_customer');

		$rows = $this->job->fetchAll($sql);

		return $rows;


	}


    /**
     * 
     * Procura cartolina por fornecedor
     * @param string $param
     */
    public function getCartolinaBySuplier($param) {
        $sql = $this->itm->select('');
    }

    /**
     * Retorna valores do cliente e os dois titulos do trabalho da folha de obra baseados no numero da obra
     * @param int $numObra
     * @return array
     */
    public function getJobData ($numObra)
    {

        $sql = $this->job->select('j_customer', 'j_title1', 'j_title2')->where('j_number = ?', (int) $numObra);
        $row = $this->job->fetchRow($sql);
        return $row;
    }

	/**
	 * @param $j_ucode2
	 * @param $j_number
	 * @param $measures
	 * @param $estante
	 * @param $plentrada
	 * @param $plimpressao
	 * @param $sfibra
	 * @param $expl
	 * @return string
	 * @throws Zend_Db_Table_Exception
	 */
    public function insertCortanteFolhaObra($j_ucode2, $j_number, $measures, $estante, $plentrada, $plimpressao, $sfibra, $expl, $fto_entrada)
    {
        $job = $this->job->find($j_number);
        
        if (!empty($job['j_number'])) {
            $values = array(
            'j_ucode2' => $j_ucode2,
            'j_ucode3' => $measures,
            'j_ucode4' => $estante,
            'j_ucode5' => $plentrada,
            'j_ucode6' => $plimpressao,
            'j_ucode7' => $sfibra,
            'j_ucode8' => $expl,
            'j_ucode9' => $fto_entrada,
               );
        $where = $this->job->getAdapter()->quoteInto('j_number = ?', (int) $j_number);
        $this->job->update($values, $where);
          return "OK";
        } else {
          return  "NOOK";
        } 
     }

	/**
	 * @param $j_number
	 * @return string
	 * @throws Zend_Db_Table_Exception
	 */
      public function removeCortanteFolhaObra($j_number)
    {
        $job = $this->job->find($j_number);
        
        if (!empty($job['j_number'])) {
            $values = array('j_ucode2' => "", 'j_ucode3' => "",'j_ucode4' => "", 'j_ucode5' => "",'j_ucode6' => "", 'j_ucode7' => "",'j_ucode8' => "",'j_ucode9' => "");
        $where = $this->job->getAdapter()->quoteInto('j_number = ?', (int) $j_number);
        $this->job->update($values, $where);
          return "OK";
        } else {
          return  "NOOK";
        
        
        } 
        
        
    }

    public function getAllFromJobTableProducao ()
    {

        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_datein` >=  '2011-01-01' AND `j_type` like '06%' AND `j_status` = 10 AND `j_qty_ordered` != 1 AND `j_qty_ordered` != 0 order by 'j_deldate' ASC");
        return $row;
    }

    public function getAllFromJobTableProducaoToday ()
    {

        $today = date('Y-m-d');
        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_datein` >=  '2011-01-01' AND `j_type` like '06%' AND `j_status` = 10 AND `j_deldate` = '$today' AND `j_qty_ordered` != 1 AND `j_qty_ordered` != 0 order by 'j_number' DESC");
        return $row;
    }

    public function getAllFromJobTableProducaoTomorrow ()
    {

        if (date('l') == 'Friday') {
            $today = new Zend_Date();
            $dayT = $today->add('3', Zend_Date::DAY);
            $tomorrow = date('Y') . '-' . App_Auxiliar_ChangeMonth::changeMonth($dayT) . '-' . $dayT;
        } else {
            $today = new Zend_Date();
            $dayT = $today->add('1', Zend_Date::DAY);
            $tomorrow = date('Y') . '-' . App_Auxiliar_ChangeMonth::changeMonth($dayT) . '-' . $dayT;
        }
        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_datein` >=  '2009-01-01' AND `j_type` like '06%' AND `j_status` != 40 AND `j_deldate` = '$tomorrow' AND `j_qty_ordered` != 1 AND `j_qty_ordered` != 0 order by 'j_number' DESC");
        return $row;
    }

    public function getAllFromJobTableEntregues ()
    {

        $year1 = date(Zend_Date::YEAR_8601) . "-01-01";
        $year2 = date(Zend_Date::YEAR_8601) . "-12-31";
        $date = $this->months();
        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE `j_type` like '06%'  AND `j_deldate` BETWEEN  '$date[0]' AND '$date[1]' order by 'j_deldate' ");
        return $row;
    }

    public function getJobNumberToDeliveryToday ()
    {

        $today = date('Y-m-d');
        $sql = $this->job->select('job');
        $sql->where('j_deldate = ?', $today);
        $sql->where("j_type like '06%'");
        $sql->where("j_status != 40");
        $sql->where("j_qty_ordered != ?", 1);
        $sql->where("j_qty_ordered != ?", 0);
        $sql->order("j_number DESC");
        $rows = $this->job->fetchAll($sql);
        return $rows;
    }

    public function searchBetweenDates ($date1, $date2)
    {

        $rows = $this->job->getAdapter()->fetchAll("SELECT * FROM `job` WHERE `j_type` like '06%' AND `j_deldate` BETWEEN '$date1' AND '$date2' order by `j_deldate`");
        return $rows;
    }

    public function searchByLabAndDate ($lab, $date)
    {

        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_customer` = '$lab' AND `j_type` like '06%' AND `j_status` = 40 AND `j_deldate` = '$date' order by 'j_number' DESC");
        return $row;
    }

    public function getAllFormDel ()
    {

        $sql = $this->del->select();
        $row = $this->del->fetchAll();
        return $row;
    }

    /**
     * Retorna o 1 campo de informação da folha de obra
     * @param int $numObra
     * @return array
     */
    public function getJobInfo1 ($numObra)
    {

        $row = $this->job->getAdapter()->fetchRow('SELECT jdoc.sect_text FROM jtx INNER JOIN jdoc ON jtx.idnum = jdoc.id WHERE (((jtx.jobnum)=?) AND ((jtx.type)="T"));', $numObra);
        return $row;
    }

    /**
     * Retorna o 2 campo de informação da folha de obra
     * @param int $numObra
     * @return array
     */
    public function getJobInfo2 ($numObra)
    {

        $row = $this->job->getAdapter()->fetchRow('SELECT jdoc.sect_text FROM jtx INNER JOIN jdoc ON jtx.idnum = jdoc.id WHERE (((jtx.jobnum)=?) AND ((jtx.type)="S") AND ((jtx.code)="job"));', $numObra);
        return $row;
    }

    /**
     * Função genérica para queries
     * @param string $query
     * @return array
     */
    public function genericQuery ($query)
    {

        $row = $this->job->getAdapter()->fetchRow($query);
        return $row;
    }

    public function genericQueryAll ($query)
    {

        $row = $this->job->getAdapter()->fetchAll($query);
        return $row;
    }

    public function getJobComments ($numObra)
    {

        $sql = $this->jtx->select('subject')->where('jobnum = ?',(int) $numObra)->where('type ="C"');
        $row = $this->jtx->fetchRow($sql);
        return $row;
    }


    public function getAllJobComments($jobnumber)
    {
        $sql  = $this->jtx->select('subject')->where('jobnum = ?',(int) $jobnumber)->where('type = "C"');
        $rows = $this->jtx->fetchAll($sql);
        return $rows;

    }

    public function getAllFromJobTableByLab ($lab)
    {

        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_datein` >=  '2009-01-01' AND `j_type` like '06%' AND `j_status` = 10 AND `j_customer` = '$lab' AND `j_qty_ordered` != 1 AND `j_qty_ordered` != 0 order by 'j_number' DESC");
        return $row;
    }

    public function getAllFromJobTableByDate ($date)
    {

        $row = $this->job->getAdapter()->fetchAll("SELECT * FROM  `job` WHERE  `j_datein` >=  '2009-01-01' AND `j_type` like '06%' AND `j_status` = 10 AND `j_deldate` = '$date' order by 'j_number' DESC");
        return $row;
    }

    public function getStateOfJob ($job)
    {

        $sql = $this->tm->select('tm_act');
        $sql->where('tm_job = ?', $job);
        $sql->order('tm_end DESC');
        $row = $this->tm->fetchRow($sql);
        return $row;
    }

    public function getAllStagesOfJob ($job)
    {

        $sql = $this->tm->select();
        $sql->where('tm_job = ?', $job);
        $sql->order('tm_start');
        $rows = $this->tm->fetchAll($sql);
        return $rows;
    }

    public function getDeliveries ($job)
    {

        $sql = $this->del->select();
        $sql->where('del_job = ?', $job);
        $rows = $this->del->fetchAll($sql);
        return $rows;
    }
    
    public function getDeliverie ($job)
    {
    
        $sql = $this->del->select();
        $sql->where('del_job = ?', $job);
        $rows = $this->del->fetchRow($sql);
        return $rows;
    }

    public function getStaffNameByCode ($code)
    {

        $sql = $this->staff->select('staf_name');
        $sql->where('staf_code = ?', $code);
        $row = $this->staff->fetchRow($sql);
        return $row;
    }

    public function machineToHuman ($code)
    {

        if ($code == null || empty($code)) {
            return 0;
        } else {
        $sql = $this->act->select('act_name');
        $sql->where('act_code = ?', $code);
        $row = $this->act->fetchRow($sql);
        return $row;
        }
    }

    public function getJobsInProvas ()
    {

        $sql = $this->job->select();
        $sql->where("`j_type` like '12%'");
        $sql->where("`j_status` = 10");
        $sql->order('j_datein DESC');
        $rows = $this->job->fetchAll($sql);
        return $rows;
    }
    
    
    public function checkObra($nObra)
    {
        $sql = $this->job->find((int) $nObra);
        return $sql;
    }
    
    
    public function getJob($numObra)
    {
        $sql = $this->job->select();
        $sql->where('j_number = ?', (int) $numObra);
        
        $row = $this->job->fetchRow($sql);
        
        return $row;
    }
    /**
     * Insert data in the user j_ucode10
     * This is a hack
     * The Optimus system don´t permit
     * The Row is modified for LongText instead od varchar 20
     * @param int $j_number
     * @param string $j_ucode10
     */
    public function insertCaixas($j_number, $j_ucode10)
    {
        $job = $this->job->find($j_number);
        
        if (!empty($job['j_number'])) {
            $values = array(
                    'j_ucode10' => $j_ucode10
            );
            $where = $this->job->getAdapter()->quoteInto('j_number = ?', (int) $j_number);
            $this->job->update($values, $where);
            return "OK";
        } else {
            return  "NOOK";
        }
    }

    private function months ()
    {

        $date = getdate();
        $year = $date['year'];
        switch ($date['mon']) {
            case 1:
                $sql = array(
                    "$year-01-01" , 
                    "$year-01-31");
                return $sql;
                break;
            case 2:
                $sql = array(
                    "$year-02-01" , 
                    "$year-02-29");
                return $sql;
                break;
            case 3:
                $sql = array(
                    "$year-03-01" , 
                    "$year-03-31");
                return $sql;
                break;
            case 4:
                $sql = array(
                    "$year-04-01" , 
                    "$year-04-30");
                return $sql;
                break;
            case 5:
                $sql = array(
                    "$year-05-01" , 
                    "$year-05-31");
                return $sql;
                break;
            case 6:
                $sql = array(
                    "$year-06-01" , 
                    "$year-06-30");
                return $sql;
                break;
            case 7:
                $sql = array(
                    "$year-07-01" , 
                    "$year-07-31");
                return $sql;
                break;
            case 8:
                $sql = array(
                    "$year-08-01" , 
                    "$year-08-31");
                return $sql;
                break;
            case 9:
                $sql = array(
                    "$year-09-01" , 
                    "$year-09-30");
                return $sql;
                break;
            case 10:
                $sql = array(
                    "$year-10-01" , 
                    "$year-10-31");
                return $sql;
                break;
            case 11:
                $sql = array(
                    "$year-11-01" , 
                    "$year-11-30");
                return $sql;
                break;
            case 12:
                $sql = array(
                    "$year-12-01" , 
                    "$year-12-31");
                return $sql;
                break;
        }
    }
    /**
     * Verifica se existe o cliente no Optimus
     * 
     * @access Arquivo Brailles Add Lab Validator
     * @param string $client
     */
    
    public function checkClientExists($client)
    {
        $cust = $this->cu->find($client);
        
        return $cust;
    }
}
?>