<?php


class App_User_Service_Laetus extends App_Master_DB_Embalagem
{

    /**
     * Liga a base de dados
     * @return Zend_DB_Table
     */
    public function __construct ()
    {

        parent::__construct();
        $this->table = new LaetusTable();
        $this->cortantes = new App_User_Service_Cortantes();
        $this->medidascortante = new App_User_Service_MedidasCortantes();
    }

    /**
     * @param string cortante
     * @param string formato
     * @param string codigolaetus
     * @param string laboratorio
     * @param string produto
     * @param string codf3
     * 
     * @return void
     */
    public function insert (array $values = array())
    {

        /* $cortante = $values['cortante'];
        
        if ($values['formato'] == "Auto") {
            $formato = $this->checkMeasuresOfCortante($values['cortante']);
        } else {
            $formato = $values['formato'];
            
        }*/
        $params = array(
            'cortante' => $this->cortantes->checkLenghtOfCortanteNumber($values['cortante']) , 
            'formato' => $values['formato'] , 
            'codigolaetus' => $this->getLastLaetusCodeFromCortanteNumber($values['cortante']) , 
            'laboratorio' => ucfirst(strtolower($values['laboratorio'])) , 
            'produto' => ucfirst($values['produto']) , 
            'codf3' => strtoupper($values['codf3']));
        $this->table->insert($params);
    }

    public function insertDossiers (array $values = array())
    {

        for ($i = 0; $i < $values['numero']; $i ++) {
            $params = array(
                'cortante' => $this->cortantes
                    ->checkLenghtOfCortanteNumber($values['cortante']) , 
                'formato' => str_replace('.', ',', $values['formato']) , 
                'codigolaetus' => $this->getLastLaetusCodeFromCortanteNumber($values['cortante']) , 
                'laboratorio' => ucfirst(strtolower($values['lab'])) , 
                'produto' => ucfirst($values['prod']) , 
                'codf3' => strtoupper($values['codf3']));
            $this->table
                ->insert($params);
        }
    }

    public function getLastLaetusCodeFromCortanteNumber ($cortanteNumber)
    {

        $sql = $this->table
            ->select()
            ->where('cortante= ?', $this->cortantes
            ->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->group('codigolaetus');
        $sql->order('codigolaetus DESC');
        $row = $this->table
            ->fetchRow($sql);
        if ($row == null) {
            return 100;
        } else {
            return $row['codigolaetus'] + 1;
        }
    }

    public function getLastLaetusCodeFromCortanteNumberForPDFCreation ($cortanteNumber)
    {

        $sql = $this->table
            ->select()
            ->where('cortante= ?', $this->cortantes
            ->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->group('codigolaetus');
        $sql->order('codigolaetus DESC');
        $row = $this->table
            ->fetchRow($sql);
        if ($row == null) {
            return 100;
        } else {
            return $row['codigolaetus'];
        }
    }

    public function getMeasuresByCortanteNumberAjaxCall ($cortanteNumber)
    {

        $sql = $this->table->select();
        $sql->where('cortante = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->order('codigolaetus DESC');
        $row = $this->table
            ->fetchRow($sql);
        return $row;
    }

    public function getValue ($cortanteNumber)
    {
      
        $sql = $this->table->select();
        $sql->where('cortante = ?', (int)$this->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->order('cortante DESC');
        $row = $this->table->fetchRow($sql);
        
        return $row;
    }

    public function getSingleArchive ($id)
    {

        /*$sql = $this->table->select();
        $sql->where('cortante = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->order('codigolaetus DESC');
        $row = $this->table->fetchRow($sql);
        return $row; */
        $row = $this->table
            ->fetchRow($this->table
            ->select()
            ->where('id = ?', $id));
        return $row->toArray();
    }

    public function getAllValuesByCortanteNumber ($cortanteNumber)
    {

        $sql = $this->table->select();
        $sql->where('cortante = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
        $sql->order('codigolaetus DESC');
        $row = $this->table ->fetchAll($sql);
        return $row;
    }

    public function delete ($id)
    {

        $where = $this->table
            ->getAdapter()
            ->quoteInto('id = ?', $id);
        $this->table
            ->delete($where);
    }

    public function update (array $values)
    {

        $params = array(
            'cortante' => $values['cortante'] , 
            'formato' => $values['formato'] , 
            'laboratorio' => $values['laboratorio'] , 
            'produto' => $values['produto'] , 
            'codf3' => strtoupper($values['codf3']));
        $where = $this->table
            ->getAdapter()
            ->quoteInto('id = ?', $values['id']);
        $this->table
            ->update($params, $where);
    }

    public function checkMeasuresOfCortante ($cortanteNumber)
    {

        $measures = $this->cortantes
            ->getMeasuresByCortanteNumber($cortanteNumber);
        if ($measures == 'xx') {
            return $this->medidascortante
                ->getMeasuresByCortanteNumber($cortanteNumber);
        } else {
            return $this->cortantes
                ->getMeasuresByCortanteNumber($cortanteNumber);
        }
    }

    public function getMeasuresByCortanteNumber ($cortanteNumber)
    {

        $sql = $this->cortantes
            ->select();
        $sql->where('codigo = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
        $row = $this->cortantes
            ->fetchRow($sql);
        return $row['A'] . "x" . $row['B'] . "x" . $row['H'];
    }
    
    
    public function checkIfValueExists($value)
    {
        
        $sql = $this->table->select();
        $sql->where('cortante =?', $this->checkLenghtOfCortanteNumber($value));
        return $row = $this->table->fetchRow($sql);
        
        
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
            default:
                return $cortanteNumber;
                break;    
        }
    }
}
?>