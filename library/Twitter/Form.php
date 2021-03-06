<?php

class Twitter_Form extends Zend_Form
{

	protected $i = 1;

	public function __construct($options = null)
	{
		// Let's load our own decorators
		$this->addPrefixPath("Twitter_Form_Decorator", "Twitter/Form/Decorator/", "decorator");

		// Get rid of all the pre-defined decorators
		$this->clearDecorators();

		// Decorators for all the form elements
		$this->setElementDecorators($this->_getElementDecorators());

		// Decorators for the form itself
		$this->addDecorator("FormElements")
			->addDecorator("Fieldset");

		parent::__construct($options);
	}

	protected function _getElementDecorators()
	{
		return array(
			"ViewHelper",
			array("Errors", array("placement" => "append", "class" => "list-unstyled spaced text-danger")),
			array("Description", array("tag" => "span", "class" => "help-block")),
			array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "col-sm-9 hr6" , "id" => "form-inner-id-".$this->i)),
			array("Label", array("class" => "col-sm-3 control-label align-right")),
			array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "form-group hr6", "id" => "form-outer-id-".$this->i))
		);
	}

	/**
	 * @see Zend_Form::addElement
	 *
	 * We have to override this, because we have to set some special decorators
	 * on a per-element basis (checkboxes and submit buttons have different
	 * decorators than other elements)
	 *
	 */
	public function addElement($element, $name = null, $options = null)
	{
		parent::addElement($element, $name, $options);

		if(!$element instanceof Zend_Form_Element && $name != null)
		{
			$element = $this->getElement($name);
		}
		// An existing instance of a form element was added to the form
		// We need to reset its decorators
		else
		{
			$element->clearDecorators();
			$element->setDecorators($this->_getElementDecorators());
			$this->i++;
		}

		if($element instanceof Zend_Form_Element_File)
		{
			$decorators = $this->_getElementDecorators();
			$decorators[0] = "File";
			$element->setDecorators($decorators);
		}

		// Special style for Zend
		if($element instanceof Zend_Form_Element_Submit
			|| $element instanceof Zend_Form_Element_Reset
			|| $element instanceof Zend_Form_Element_Button)
		{
			$class = "";

			if($element instanceof Zend_Form_Element_Submit
				&& !($element instanceof Zend_Form_Element_Reset)
			 	&& !($element instanceof Zend_Form_Element_Button))
			{
				$class = "btn-primary";
			}

			$element->setAttrib("class", trim("btn $class " . $element->getAttrib("class")));
			$element->removeDecorator("Label");
			$element->removeDecorator("outerwrapper");
			$element->removeDecorator("innerwrapper");

			$this->_addActionsDisplayGroupElement($element);

			//$element->addDecorator(array(
				//"outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "actions")
			//);
		}

		/*if($element instanceof Zend_Form_Element_Checkbox)
		{
			$element->setDecorators(array(
				array(array("labelopening" => "HtmlTag"), array("tag" => "label", "class" => "checkbox", "id" => $element->getId()."-label", "for" => $element->getName(), "openOnly" => false)),
				"ViewHelper",
				array("Checkboxlabel"),
				array(array("labelclosing" => "HtmlTag"), array("tag" => "label", "closeOnly" => true)),
				array("Errors", array("placement" => "append")),
				array("Description", array("tag" => "span", "class" => "help-block")),
				//array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "ace")),
				array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "checkbox"))
			));
		}*/

		if($element instanceof Zend_Form_Element_Radio
			|| $element instanceof Zend_Form_Element_MultiCheckbox)
		{
			$multiOptions = array();
			foreach($element->getMultiOptions() as $value => $label)
			{
				$multiOptions[$value] = " ".$label;
			}

			$element->setMultiOptions($multiOptions);

			$element->setAttrib("labelclass", "checkbox");

			if($element->getAttrib("inline"))
			{
				$element->setAttrib("labelclass", "checkbox inline");
			}

			if ($element instanceof Zend_Form_Element_Radio)
			{
				$element->setAttrib("labelclass", "radio");
			}

			if($element->getAttrib("inline"))
			{
				$element->setAttrib("labelclass", "radio inline");
			}

			$element->setOptions(array("separator" => ""));
			$element->setDecorators(array(
				"ViewHelper",
				array("Errors", array("placement" => "append", "class" => "list-unstyled spaced text-danger")),
				array("Description", array("tag" => "span", "class" => "help-block")),
				array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "col-sm-9 hr6" , "id" => "form-inner-id-".$this->i)),
				array("Label", array("class" => "col-sm-3 control-label align-right")),
				array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "form-group hr6", "id" => "form-outer-id-".$this->i))
			));


			/*
			 * return array(
			"ViewHelper",
			array("Errors", array("placement" => "append", "class" => "list-unstyled spaced text-danger")),
			array("Description", array("tag" => "span", "class" => "help-block")),
			array(array("innerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "col-sm-9 hr6" , "id" => "form-inner-id-".$this->i)),
			array("Label", array("class" => "col-sm-3 control-label align-right")),
			array(array("outerwrapper" => "HtmlTag"), array("tag" => "div", "class" => "form-group hr6", "id" => "form-outer-id-".$this->i))
		);
			 */

		}

		if($element instanceof Zend_Form_Element_Hidden)
		{
			$element->setDecorators(array("ViewHelper"));
		}
		
		if($element instanceof Zend_Form_Element_Textarea && !$element->getAttrib('rows'))
		{
			$element->setAttrib('rows', '3');
		}
		
		if($element instanceof Zend_Form_Element_Captcha)
		{
			$element->removeDecorator("viewhelper");
		}

        return $this;
	}

	private function _addActionsDisplayGroupElement($element)
	{
		$displayGroup = $this->getDisplayGroup("zfBootstrapFormActions");

		if($displayGroup === null)
		{
			$displayGroup = $this->addDisplayGroup(
				array($element),
				"zfBootstrapFormActions",
				array(
					"decorators" => array(
						"FormElements",
						array("HtmlTag", array("tag" => "div", "class" => "rps_controls"))
					)
				));
		}
		else
		{
			$displayGroup->addElement($element);
		}

		return $displayGroup;
	}
	/**
	 * Render
	 * @param  Zend_View_Interface $view
	 * @return Zend_View
	 */
	public function render(Zend_View_Interface $view = null)
	{
        $formTypes = array( // avaible form types of Twitter Bootstrap form (i.e. classes)
          'horizontal',
          'inline',
          'vertical',
          'search'
        );
        
        $set = false;
        
        foreach($formTypes as $type) {
            if($this->getAttrib($type)) {
                $this->addDecorator("Form", array("class" => "form-$type"));
                $set = true;
            } 
        }
        if(true !== $set) { // if neither type was set, we set the default vertical class
            $this->addDecorator("Form", array("class" => "form-vertical"));
        }

		return parent::render($view);
	}
}
