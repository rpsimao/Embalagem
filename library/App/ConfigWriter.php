<?php
/**
 * Classe genérica para escrever no ficheiro de configuração.
 * 
 * @author Ricardo Simão <code@rpsimao.com>
 * 
 * @version 1.0
 *
 */

class App_ConfigWriter {
	
	/**
	 * nome do ficheiro de configuração
	 * Tem de incluir o caminho
	 *
	 * @var string
	 */
	protected $iniFile;
	
	/**
	 * Inicializa o ficheiro de configuração
	 *
	 * @var array
	 */
	protected $config;
	
	/**
	 * Escreve os valores no ficheiro de configuração
	 *
	 * @var array
	 */
	protected $writer;
	
	/**
	 * Define o caminho e nome do ficheiro de configuração
	 *
	 * @param string $iniFile
	 */
	function __construct($iniFile) {
		$this->iniFile = $iniFile;
	}
	/**
	 * Prepara os ficheiro de configuração para poder ser alterado
	 *
	 * @return unknown
	 */
	public function setConfig() {
		$config = new Zend_Config_Ini ( $this->iniFile, NULL, array ('skipExtends' => TRUE, 'allowModifications' => TRUE ) );
		return $config;
	}
	/**
	 * Escreve os valores no ficheiro de configuração
	 *
	 * @param string $config
	 */
	public function write($config) {
		$writer = new Zend_Config_Writer_Ini ( array ('config' => $config, 'filename' => $this->iniFile ) );
		$writer->write ();
	}

}