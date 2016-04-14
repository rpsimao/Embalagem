
<?php
/**
 *
 * Enter description here ...
 *
 * @author Ricardo Simão - ricardo.simao@fterceiro.pt
 * @copyright 2011 - Fernandes & Terceiro, SA
 * @copyright All right reserved.
 * @license Although this script is provided with source code it does NOT mean that this report is in the public domain.
 *
 * @version 1.0 - Dec 12, 2012 12:18:01 PM
 *
 * @category Printshop
 * @package
 *
 */
 


class App_User_Service_ArqBrailles_List extends App_Master_DB_Embalagem
{
    
    protected $optimus;
    protected $jobData2;
    
    
    public function __construct()
    {
        $this->optimus  = new App_User_Service_Optimus();
        $this->jobData2 = $this->optimus->getJobInfo2($numobra);
    }
    
    
}