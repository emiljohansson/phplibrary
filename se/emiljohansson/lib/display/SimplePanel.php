<?php

/**
 *	{LIBRARY_NAME}
 *
 *	PHP Version 5.3
 *
 *	Inspired by the GWT library <http://www.gwtproject.org/>
 *
 *	@copyright	Emil Johansson 2013
 *	@license	http://www.opensource.org/licenses/mit-license.php MIT
 *	@link		https://github.com/emiljohansson
 */

//-----------------------------------------------------------
//	Public class
//-----------------------------------------------------------

/**
 *	Panel for initialize a display object as either a Widget or Element.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 *	@todo		Only allow a single added widget.
 */
class SimplePanel extends Panel
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	The only allowed widget.
	 *	@var Widget
	 */
	protected $widget;

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Handles the parameter and initializes it correctly.
	 *	
	 *	@param	mixed	$mixedObject
	 *	@return void
	 *	@throws	Exception
	 */
	public function __construct($mixedObject = null) 
	{
		parent::__construct();
		$this->initParamObject($mixedObject);
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Sets the base widget instance and adds it to the panel.
	 *
	 *	@param	Widget	$widget
	 *	@return	void
	 */
	public function setWidget(Widget $widget) 
	{
		$this->widget = $widget;
		$this->add($widget);
	}

	/**
	 *	Overrides the parent method to double check that the
	 *	element has been initialized.
	 *
	 *	@return	void
	 */
	public function load() 
	{
		$elem = $this->getElement();
		if (!isset($elem) && isset($this->widget)) {
			Console::log($this->widget->getElement());
			$this->setElement($this->widget->getElement());
		}
		parent::load();
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Initializes either as string, Element or Widget.
	 *
	 *	@param	mixed	$mixedObject
	 *	@return	void
	 */
	protected function initParamObject($mixedObject = null) 
	{
		if (!isset($mixedObject)) {
			$this->initAsStandard();
		}
		else if (is_subclass_of($mixedObject, "Element") || get_class($mixedObject) == "Element") {
			$this->initAsElement($mixedObject);
		}
		else if (is_subclass_of($mixedObject, "Widget") || get_class($mixedObject) == "Widget") {
			$this->initAsWidget($mixedObject);
		}
		else {
			throw new Exception("Parameter object has to be either null, Element or a Widget", 1);
		}
	}

	/**
	 *	Helper method, initializes the the panel as a div element.
	 *
	 *	@return	void
	 */
	protected function initAsStandard() 
	{
		$this->setElement(DOM::createDiv());
	}

	/**
	 *	Helper method, initializes the the panel as an element.
	 *
	 *	@param	Element	$element
	 *	@return	void
	 */
	protected function initAsElement(Element $element) 
	{
		$this->setElement($element);
	}

	/**
	 *	Helper method, initializes the the panel as a widget.
	 *
	 *	@param	Widget	$widget
	 *	@return	void
	 */
	protected function initAsWidget(Widget $widget) 
	{
		$this->setWidget($widget);
		$this->initAsElement($widget->getElement());
	}
}