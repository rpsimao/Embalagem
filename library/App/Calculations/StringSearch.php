<?php

/** 
 * @author rpsimao
 * 
 * 
 */
class App_Calculations_StringSearch
{
    /**
     * 
     * First delimiter string
     * @var string
     */
    private $string1;
    /**
     * 
     * second delimiter string
     * @var string
     */
    private $string2;
    /**
     * 
     * Text to be search
     * @var string
     */
    private $contents;
    
    /**
     * 
     * Set text to be search
     * @param string $contents
     */    
    public function setContents($contents)
    {
       $this->contents = $contents; 
    }
    /**
     * 
     * Get text to be search
     * @param string $contents
     */  
    private function _getContents()
    {
        return $this->contents;
    }
    
    /**
     * 
     * Set First delimiter string
     * @var string
     */
    public function setString1($string1)
    {
        $this->string1 = $string1;
    }
    /**
     * 
     * Get first delimiter string
     * @var string
     */
    private function _getString1()
    {
        return $this->string1;
    }
    /**
     * 
     * Set second delimiter string
     * @var string
     */
    public function setString2($string2)
    {
        $this->string2 = $string2;
    }
    /**
     * 
     * Get second delimiter string
     * @var string
     */
    private function _getString2()
    {
        return $this->string2;
    }
    
    
    /**
     * Search for a string in a selected text
     * Return string
     */
    public function search()
    {
        
        $between = substr($this->_getContents(), strpos($this->_getContents(), $this->_getString1()), strpos($this->_getContents(), $this->_getString2()) - strpos($this->_getContents(), $this->_getString1()));
        
        $replace = str_replace($this->_getString1(), '', $between);
        
        if (preg_match('/[PE]/i', $replace)) {
            $notabs = str_replace("\t", '', $replace);
        } else {
            $nospaces = str_replace(' ', '', $replace);
            $notabs   = str_replace("\t", '', $nospaces);
        }
        return $notabs;
    }
    
    
    public function regExpSearch()
    {
        preg_match_all('/'.$this->_getString1().'(.*?)'.$this->_getString2().'/si', $this->_getContents(), $matches);
        return implode("", $matches[1]);
    }
    
    
    
    public function search1RegularExpr($regexp1)
    {
        $text = $this->search();
        $search = preg_match("/".$regexp1."/i",$text) ? "Sim" : "Nao";
    
        return $search;
    }
     
    public function search2RegularExpr($regexp1, $regexp2)
    {
        $text = $this->search();
        $search = preg_match("/".$regexp1."/i",$text) || preg_match("/".$regexp2."/i",$text)  ? "Sim" : "Nao";
    
        return $search;
    }
     
    public function search3RegularExpr($regexp1, $regexp2, $regexp3)
    {
        $text = $this->search();
        $search = preg_match("/".$regexp1."/i",$text) || preg_match("/".$regexp2."/i",$text) || preg_match("/".$regexp3."/i",$text) ? "Sim" : "Nao";
    
        return $search;
    }
    
    
    
    
    /**
     * Convert the carton type to the DB format for retrive
     * It shouldn´t be here, I was lazy
     * @param string $carton
     */
    public function filterCarton($carton)
    {
        
        $cleanSpaces = str_replace(' ', '', $carton);
        $cleanLastChar = substr($cleanSpaces, 0, -1);
        
        
        if (preg_match("/Cromoduplex300/i", $cleanLastChar))
        {
           return 'GC2/300g';
        }
        else if (preg_match("/Cromoduplex280/i", $cleanLastChar))
        {
          return 'GC2/280g';
        }
        else if (preg_match("/Cromoduplex265/i", $cleanLastChar))
        {
          return 'GC2/265g';
        }
        else if (preg_match("/Cromoduplex275/i", $cleanLastChar))
        {
          return 'GC2/275g';
        }
        else if (preg_match("/Cromoduplex285/i", $cleanLastChar))
        {
          return 'GC2/285g';
        }
        else if (preg_match("/Cromoduplex340/i", $cleanLastChar))
        {
          return 'GC2/340g';
        }
        else if (preg_match("/Cromoduplex350/i", $cleanLastChar))
        {
          return 'GC2/350g';
        }
        else if (preg_match("/Cromoduplex400/i", $cleanLastChar))
        {
          return 'GC2/400g';
        }
        else if (preg_match("/GC1350g/i", $cleanLastChar))
        {
          return 'GC1/350g';
        }
        else if (preg_match("/GD2280g/i", $cleanLastChar))
        {
          return 'GD2/280g';
        }
        else if (preg_match("/Couché200g/i", utf8_encode($cleanLastChar)))
        {
          return 'Couche/200g';
        }
        else if (preg_match("/Couché150g/i", utf8_encode($cleanLastChar)))
        {
          return 'Couche/150g';
        }
        else if (preg_match("/Couché250g/i", utf8_encode($cleanLastChar)))
        {
          return 'Couche/250g';
        }
        else if (preg_match("/GC2275g/i", utf8_encode($cleanLastChar)))
        {
          return 'GC2/275g';
        }
        else if (preg_match("/GC1300g/i", utf8_encode($cleanLastChar)))
        {
          return 'GC1/300g';
        }
        else if (preg_match("/GD2300g/i", utf8_encode($cleanLastChar)))
        {
          return 'GD2/300g';
        }
        else if (preg_match("/GC2300g/i", utf8_encode($cleanLastChar)))
        {
          return 'GC2/300g';
        }
        else if (preg_match("/IOR60g/i", utf8_encode($cleanLastChar)))
        {
            return 'IOR/60g';
        }
        else if (preg_match("/IOR80g/i", utf8_encode($cleanLastChar)))
        {
            return 'IOR/80g';
        }
        else if (preg_match("/IOR90g/i", utf8_encode($cleanLastChar)))
        {
            return 'IOR/90g';
        }
        else if (preg_match("/[GT1 300g + 15g PE]/i", $carton))
        {
            return 'GT1 300g + 15g PE/300g';
        }
        
        else {
            return $carton;
        }
    }

}