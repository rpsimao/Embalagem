<?php

class App_User_Service_CortantesExecucao extends App_Master_DB_Embalagem
{

    public function __construct ()
    {

        parent::__construct();
        $this->cortante = new CortantesexecucaoTable();
    }

    public function update (array $values)
    {

        $where = $this->cortante
            ->getAdapter()
            ->quoteInto('id = ?', $values['id']);
         $sql = $this->cortante->update($values, $where);
         return $sql;
            
    }

    public function insert (array $values)
    {

        
        $abh = explode("x", $values['abh']);
        $params = array(
            'cortante' => $values['cortante'] , 
            'autoplatina' => $values['autoplatina'] , 
            'cilindrica' => $values['cilindrica'] , 
            'a' => $abh['0'] , 
            'b' => $abh['1'] , 
            'h' => $abh['2'] , 
            'f' => $values['f'] , 
            'g' => $values['g'] , 
            'pala' => $values['pala'] , 
            'tipo' => $values['tipo'] , 
            'caixas' => $values['caixas'] , 
            'requisicao' => $values['requisicao'] , 
            'dataenvio' => $values['dataenvio'] , 
            'datapedida' => $values['datapedida']);
        if ($values['id'] == NULL) {
            $this->cortante
            ->insert($params);;
        } else {
            $arrayID = array('id' => $values['id']);
            $result = array_merge($params, $arrayID);
            $this->update($result);
        }
        
    }

    public function delete ($id)
    {

        $where = $this->cortante
            ->getAdapter()
            ->quoteInto('id = ?', $id);
        $this->cortante
            ->delete($where);
    }

    public function getAll ()
    {

        $sql = $this->cortante
            ->select()
            ->where('entregue != 1')
            ->order('cortante DESC');
        return $this->cortante
            ->fetchAll($sql);
    }

    public function getLastCortante ()
    {

        $sql = $this->cortante
            ->select('cortante')
            ->order('cortante DESC');
        return $this->cortante
            ->fetchRow($sql);
    }

    public function getSingleCortante ($id)
    {

        $sql = $this->cortante
            ->select()
            ->where('id =?', $id);
        return $this->cortante
            ->fetchRow($sql);
    }
}
?>