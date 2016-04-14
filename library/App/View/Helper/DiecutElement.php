<?php

class App_View_Helper_DiecutElement extends Zend_View_Helper_FormElement
{

    protected $html = '';

    public function diecutElement ($name, $value = null, $attribs = null)
    {

        $a = $b = $h = '';
        if ($value)
            list ($a, $b, $h) = explode('x', $value);
        $helper = new Zend_View_Helper_FormText();
        $helper->setView($this->view);
        if (is_array($value)) {
            $a = (isset($value['a'])) ? $value['a'] : '';
            $b = (isset($value['b'])) ? $value['b'] : '';
            $h = (isset($value['h'])) ? $value['h'] : '';
        }
        $this->html .= $helper->formText($name . '[a]', $a, array(
            'size' => 5 , 
            'maxlength' => 5 , 
            'class' => 'rounded-textbox_mini'));
        $this->html .= $helper->formText($name . '[b]', $b, array(
            'size' => 5 , 
            'maxlength' => 5 , 
            'class' => 'rounded-textbox_mini'));
        $this->html .= $helper->formText($name . '[h]', $h, array(
            'size' => 5 , 
            'maxlength' => 5 , 
            'class' => 'rounded-textbox_mini'));
        return $this->html;
    }
}
?>