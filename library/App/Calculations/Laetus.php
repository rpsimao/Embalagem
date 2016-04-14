<?php

class App_Calculations_Laetus
{

    protected $barras = array();



    public function setValue ($value)
    {

        $this->value = $value;
    }

    public function getValue ()
    {

        return $this->value;
    }

    public function generateTempFile ()
    {

        $c = uniqid(rand(), true);
        $sess = new Zend_Session_Namespace('temfilename');
        $tempfile = $sess->filename = $c;
        return $tempfile;
    }

    public function setFile ()
    {

        $session = new Zend_Session_Namespace('temfilename');
        $file = "/tmp/" . $session->filename;
        if (! file_exists($file)) {
            system("touch " . $file);
        }
        return $file;

    }

    private function getFirstNumber ()
    {

        $number = (($this->getValue() & 1) ? 1 : 0);
        return $number;
    }

    public function dealWithNumber ($value)
    {

        $number = (($value & 1) ? 'impar' : 'par');
        switch ($number) {
            case 'par':
                if ($value > 0) {
                    $x = ($value - 2) / 2;
                    $fh = fopen($this->setFile(), 'a');
                    fwrite($fh, $x . ",");
                    fclose($fh);
	                $this->dealWithNumber($x);
                }
                break;
            case 'impar':
                if ($value > 0) {
                    $x = ($value - 1) / 2;
                    $fh = fopen($this->setFile(), 'a');
                    fwrite($fh, $x . ",");
	                $this->dealWithNumber($x);
                }
                break;
        }




    }

    public function handleNumbers ()
    {

	    $contents = file_get_contents($this->setFile());
        $exp      = explode(",", $contents);
        $elements = count($contents);
        $elements = $elements - 2;
        array_splice($exp, $elements);
        array_unshift($exp, $this->getValue());
        $exp = array_reverse($exp);
        $binary = array();
        foreach ($exp as $value) {
            $number = (($value & 1) ? 1 : 0);
            $binary[] = $number;
        }
        return $binary;
    }

    public function __destruct ()
    {

        unlink($this->setFile());
        Zend_Session::destroy(true);
    }
}