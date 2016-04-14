<?php
include_once 'MedidascortantesTable.php';

class App_User_Service_MedidasCortantes extends App_Master_DB_Embalagem
{

    public function __construct ()
    {

        parent::__construct();
        $this->medidascortante = new MedidascortantesTable();
    }

    public function insert ($codigo, $medidas)
    {

        $medidasSingle = explode("x", $medidas);
        $params = array(
            'codigo' => $codigo , 
            'A' => $medidasSingle[0] , 
            'B' => $medidasSingle[1] , 
            'H' => $medidasSingle[2]);
        $this->medidascortante
            ->insert($params);
    }

    public function getMeasuresByCortanteNumber ($cortanteNumber)
    {

        if (is_int($cortanteNumber)) {
            $sql = $this->medidascortante
                ->select();
            $sql->where('codigo = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
            $row = $this->medidascortante
                ->fetchRow($sql);
            return $row['A'] . "x" . $row['B'] . "x" . $row['H'];
        } else {
            return 0;
        }
    }

    public function checkLenghtOfCortanteNumber ($cortanteNumber)
    {

        switch (strlen($cortanteNumber)) {
            case 1:
                return '0000' . $cortanteNumber;
                break;
            case 2:
                return '000' . $cortanteNumber;
                break;
            case 3:
                return '00' . $cortanteNumber;
                break;
            case 4:
                return '0' . $cortanteNumber;
                break;
        }
    }
}
?>