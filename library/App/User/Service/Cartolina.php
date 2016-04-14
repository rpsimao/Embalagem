<?php
/**
 * Classe para efectuar pedidos á tabela cartolinas da base de dados embalagem (MySQL)
 * 
 * @author Ricardo Simao
 * @version 1.0
 * @copyright Fernandes & Terceiro, S.A.
 * @package Embalagem Database
 * 
 * @abstract Ultima revisao - 14/08/2009
 */

class App_User_Service_Cartolina extends App_Master_DB_Embalagem
{
    /**
     * Define a tabela a usar
     * @var Zend_Db_Table
     */
    protected $cartolina;
    /**
     * seleciona as cartolinas
     * @var array
     */
    protected $select;
    /**
     * executa um pedido à base de dados
     * @var string
     */
    protected $sql;
    /**
     * Retorna os valores do pedido à base de dados
     * @var array
     */
    protected $row;
    
    /**
     * Liga à base de dados e define a tabela a usar
     * @return Zend_Db_Table
     */
    function __construct ()
    {

        parent::__construct();
        $this->cartolina = new CartolinaTable();
    }
    /**
     * Recupera todos os valores da tabela ordenados por tipo e gramagem
     * @return array
     */
    public function getValues ()
    {

        $select = $this->cartolina->select ();
		$select->order ( 'tipo' )->order('gramagem');
		return $this->cartolina->fetchAll ( $select );
    }

    /**
     * Baseado no tipo de cartolina retorna a espessura da mesma
     * @param string $tipo
     * @param int $gramagem
     * @return array
     */
    public function getEspessura($tipo, $gramagem) 
    {
        $sql = $this->cartolina->select('espessura')->where("tipo = '$tipo' AND gramagem = '$gramagem'");
        $row = $this->cartolina->fetchRow($sql);
        return $row;
    }
    
    /**
     * Baseado no tipo de cartolina PE retorna a espessura da mesma
     * @param string $tipo
     * @return array
     */
    public function getEspessuraPE($tipo)
    {
        $sql = $this->cartolina->select('espessura')->where("tipo = '$tipo'");
        $row = $this->cartolina->fetchRow($sql);
        return $row;
    }
    
    /**
     * Insere novos valores
     * @param array $params
     */
    public function insert(array $params = array())
    {
        
        $data = array('tipo' => $params['tipo'], 'gramagem' => $params['gramagem'], 'espessura' => $params['espessura']);
        
        $sql = $this->cartolina->insert($data);
        
    }
    
    public function getCartolinaType()
    {
       
         $sql = $this->cartolina->getAdapter()->fetchAll("select `tipo` from `cartolina` GROUP BY `tipo`");
         return $sql;
        
    }
    
}
?>