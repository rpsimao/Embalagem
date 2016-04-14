<?php

/** 
 * @author rpsimao
 * 
 */
class App_Service_Search_Folhaobra
{
    
    public function __construct($jobData1, $jobData2)
     {
        $this->jobData1 = $jobData1;
        $this->jobData2 = $jobData2;
        
        $this->stringSearch = new App_Calculations_StringSearch();
        
        
     }
     
     
    public function setText($text)
    {
        $this->text = $text;
    }
    
    
    private function _getText()
    {
        return $this->text;
    }
    
    public function setString1($string1)
    {
        $this->string1 = $string1;
    }
    
    
    private function _getString1()
    {
        return $this->string1;
    }
    
    public function setString2($string2)
    {
        $this->string2 = $string2;
    }
    
    
    private function _getString2()
    {
        return $this->string2;
    }
     
     
     
     
     public function searchGeneric()
     {
         $this->stringSearch->setContents($this->jobData1[$this->_getText()]);
         $this->stringSearch->setString1($this->_getString1());
         $this->stringSearch->setString2($this->_getString2());
         $texto = $this->stringSearch->search();
         
         return $texto;
     }
     
     
     
     public function search1RegularExpr($regexp1)
     {
         $text = $this->searchGeneric();
         $search = preg_match("/".$regexp1."/i",$text) ? "Sim" : "Nao";
          
         return $search;
     }
     
     public function search2RegularExpr($regexp1, $regexp2)
     {
         $text = $this->searchGeneric();
         $search = preg_match("/".$regexp1."/i",$text) || preg_match("/".$regexp2."/i",$text)  ? "Sim" : "Nao";
          
         return $search;
     }
     
     public function search3RegularExpr($regexp1, $regexp2, $regexp3)
     {
         $text = $this->searchGeneric();
         $search = preg_match("/".$regexp1."/i",$text) || preg_match("/".$regexp2."/i",$text) || preg_match("/".$regexp3."/i",$text) ? "Sim" : "Nao";
          
         return $search;
     }
     
    
    
}
?>