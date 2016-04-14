<?php
require_once 'CortantesTable.php';

class App_User_Service_Cortantes extends App_Master_DB_Embalagem
{

    public function __construct ()
    {

        parent::__construct();
        $this->cortante = new CortantesTable();
    }

    public function getAllByType ($flag)
    {

        switch ($flag) {
            case 'autoplatina':
                $sql = $this->cortante->select()->where('cortante LIKE "CA%"');
                $sql->order('codigo');
                $rows = $this->cortante->fetchAll($sql);
                if (! $rows) {
                    throw new Exception("Não existe nenhum cortante.");
                }
                return $rows;
                break;
            case 'cilindrica':
                $sql = $this->cortante->select()->where('cortante LIKE "CC%"');
                $sql->order('codigo');
                $rows = $this->cortante->fetchAll($sql);
                if (! $rows) {
                    throw new Exception("Não existe nenhum cortante.");
                }
                return $rows;
                break;
        }
    }

    /**
     * 
     * @param int $codigo
     * @return Zend_Db_Table_Row
     */
    public function getSingleArchive ($codigo)
    {

        $sql = $this->cortante->select()->where('id = ?', $codigo);
        $row = $this->cortante->fetchRow($sql);
        return $row;
    }
    
      public function getSingleArchiveJSON($codigo)
        {
            $row = $this->getSingleArchive($codigo);
	        $result = $row->toArray();
            return Zend_Json_Encoder::encode($result);
        }

    public function genericSearch ($what, $query, $delimiter)
    {

        $query = str_replace(",", ".", $query);
        switch ($what) {
            case "cortante":
                $sql = $this->cortante->select()->where('cortante LIKE "%' . $query . '%"');
                $rows = $this->cortante->fetchAll($sql);
                return $rows;
                break;
            case "codigo":
                $sql = $this->cortante->select()->where('codigo LIKE "%' . $query . '%"');
                $rows = $this->cortante->fetchAll($sql);
                return $rows;
                break;
            case "A":
                $sql = $this->cortante->select()->where('A = ?', $query);
                $rows = $this->cortante->fetchAll($sql);
                return $rows;
                break;
            case "A_B":
                $explode = explode($delimiter, $query);
                if (@$explode[1] == NULL) {
                    $explode[1] = 0;
                }
                $sql = $this->cortante->select();
                $sql->where('A = ?', $explode[0]);
                $sql->where('B = ?', $explode[1]);
                $rows = $this->cortante->fetchAll($sql);
                return $rows;
                break;
            case "A_B_H":
                $explode = explode($delimiter, $query);
                if (@$explode[1] == NULL) {
                    $explode[1] = 0;
                    $explode[2] = 0;
                }
                $sql = $this->cortante->select();
                $sql->where('A = ?', $explode[0]);
                $sql->where('B = ?', $explode[1]);
                $sql->where('H = ?', $explode[2]);
                $rows = $this->cortante->fetchAll($sql);
                return $rows;
                break;
        }
    }


	public function returnJSON($rows)
	{

		$array = Zend_Json_Encoder::encode($rows);

		return $array;


	}



    public function searchByCode ($code)
    {

        $sql = $this->cortante->select()->where('codigo = ?', $code);
        $rows = $this->cortante->fetchAll($sql);
        return $rows;
    }
    
    public function searchByCleanCode ($code)
    {
    
        $sql = $this->cortante->select()->where('codigo = ?', $this->checkLenghtOfCortanteNumber($code));
        $rows = $this->cortante->fetchRow($sql);
        return $rows;
    }
    
    
    public function searchByCortanteName($name)
    {
        $sql = $this->cortante->select()->where('cortante = ?', $name);
        $rows = $this->cortante->fetchRow($sql);
        return $rows;
    }

    public function update (array $values)
    {

        $filter = new App_Filters_RemoveAllWhitespaces();

	    $params = array(
            'id'                  => $values['id'] , 
            'estante'             => $values['estante'] , 
            'codigo'              => $values['codigo'] , 
            'cortante'            => $values['cortante'] , 
            'A'                   => $values['A'] , 
            'B'                   => $values['B'] , 
            'H'                   => $values['H'] , 
            'f'                   => $values['f'] , 
            'g'                   => $values['g'] , 
            'pala'                => $values['pala'] , 
            'tipo'                => $values['tipo'] , 
            'formato_util'        => $values['formato_util'] ,
            'formato_otimizado'   => $values['formato_otimizado'] ,
            'formato_entrada'     => $filter->filter($values['formato_entrada']) ,
            'espaco'              => $values['espaco'] , 
            'braille1'            => $values['braille1'] , 
            'braille2'            => $values['braille2'] , 
            'braille3'            => $values['braille3'] , 
            'formato_std'         => $values['formato_std'] , 
            'descasque'           => $values['descasque'],
            'obs'                 => $values['obs'],
	        'alteracoes'          => $values['alteracoes'],
            'pl_entrada'          => $filter->filter($values['pl_entrada']),
            'pl_impressao'        => $filter->filter($values['pl_impressao']),
            'sentido_fibra'       => $filter->filter($values['sentido_fibra']),
            'ex_pl'               => $filter->filter($values['ex_pl']),

        );
        $where = $this->cortante->getAdapter()->quoteInto('id = ?', $values['id']);
        $this->cortante->update($params, $where);
    }

    public function insert (array $values)
    {
        $params = array(
            'estante'             => $values['estante'] , 
            'codigo'              => $values['codigo'] , 
            'cortante'            => $values['cortante'] , 
            'A'                   => $values['A'] , 
            'B'                   => $values['B'] , 
            'H'                   => $values['H'] , 
            'f'                   => $values['f'] , 
            'g'                   => $values['g'] , 
            'pala'                => $values['pala'] , 
            'tipo'                => $values['tipo'] , 
            'formato_util'        => $values['formato_util'] ,
            'formato_otimizado'   => $values['formato_otimizado'] ,
            'formato_entrada'     => $values['formato_entrada'] , 
            'espaco'              => $values['espaco'] , 
            'braille1'            => $values['braille1'] , 
            'braille2'            => $values['braille2'] , 
            'braille3'            => $values['braille3'] , 
            'formato_std'         => $values['formato_std'], 
            'descasque'           => $values['descasque'],
            'obs'                 => $values['obs'],
	        'alteracoes'          => $values['alteracoes']);
        $this->cortante->insert($params);
    }

    public function delete ($id)
    {

        $where = $this->cortante->getAdapter()->quoteInto('id = ?', $id);
        $this->cortante->delete($where);
    }

    public function getMeasuresByMeasures ($measures)
    {

        if (strlen($measures) > 4) {
            $measures = explode("x", $measures);
            $sql = $this->cortante->select();
            $sql->where('A = ?', $measures[0]);
            $sql->where('B = ?', $measures[1]);
            $sql->where('H = ?', $measures[2]);
            $row = $this->cortante->fetchRow($sql);
            return $row['codigo'];
        } else 
            if ($measures == "Auto") {
                return 0;
            } else {
                return 1;
            }
    }

    public function getMeasuresByCortanteNumber ($cortanteNumber)
    {

        $sql = $this->cortante->select();
        $sql->where('codigo = ?', $this->checkLenghtOfCortanteNumber($cortanteNumber));
        $row = $this->cortante->fetchRow($sql);
        return $row['A'] . "x" . $row['B'] . "x" . $row['H'];
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