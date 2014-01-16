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
 *	The base of all display objects.
 *
 *	All widgets is extending from this class. It stores the instance of
 *	an element and the list of attributes.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
abstract class UIObject
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	DOM element.
	 *	@var Element
	 */
	protected $element;

	/**
	 *	A list of attributes for the widget element.
	 *	@var array
	 */
	protected $attributes;
	
	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Base constructor, does nothing.
	 *
	 *	@return void
	 */
	public function __construct() {}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns the element.
	 *
	 *	@return	DOMNode
	 */
	public function getElement()
	{
		return $this->element;
	}

	/**
	 *	Sets the element.
	 *
	 *	@param	Element	$element
	 *	@return void
	 */
	public function setElement($element)
	{
		$this->element = $element;
	}

	/**
	 *	Adds a style, css class, to the element.
	 *
	 *	@param	string	$styleName
	 *	@return	Widget
	 */
	public function addStyleName($styleName) 
	{
		$this->initAttributeList();
		if (!isset($this->attributes['class'])) {
			$this->setStyleName($styleName);
		}
		else {
			$this->attributes['class'] .= " ".$styleName;
		}
		return $this;
	}

	/**
	 *	Sets one style, css class, to the element.
	 *
	 *	@param	string	$styleName
	 *	@return	Widget
	 */
	public function setStyleName($styleName) 
	{
		$this->initAttributeList();
		$this->attributes['class'] = $styleName;
		return $this;
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Initializes the list of attributes.
	 *
	 *	@param		
	 *	@return	void
	 */
	protected function initAttributeList()
	{
		if (isset($this->attributes)) return;
		$this->attributes = array();
	}
}