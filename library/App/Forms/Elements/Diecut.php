<?php

class App_Forms_Elements_Diecut extends Zend_Form_Element_Xhtml
{

    public $helper = 'diecutElement';

    protected $a = null;

    protected $b = null;

    protected $h = null;

    function setANum ($num)
    {

        $this->a = $num;
        return $this;
    }

    function setBNum ($num)
    {

        $this->b = $num;
        return $this;
    }

    function setHNum ($num)
    {

        $this->h = $num;
        return $this;
    }

    public function setValue ($value)
    {

        if (is_array($value) && (isset($value['a'])) && (isset($value['b'])) && (isset($value['h']))) {
            $this->setANum($value['a'])
                ->setBNum($value['b'])
                ->setHNum($value['h']);
        }
    }

    public function getValue ()
    {

        if (! $this->a || ! $this->b || ! $this->h)
            return false;
        return $this->a . 'x' . $this->b . 'x' . $this->h;
    }
}
?>