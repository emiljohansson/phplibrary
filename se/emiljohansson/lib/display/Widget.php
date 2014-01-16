<?php

/**
 *	{LIBRARY_NAME}
 *
 *	PHP Version 5.3
 *
 *	@copyright	Emil Johansson 2013
 *	@license	http://www.opensource.org/licenses/mit-license.php MIT
 *	@link		https://github.com/emiljohansson
 */

//-----------------------------------------------------------
//	Public class
//-----------------------------------------------------------

/**
 *	The base for managing DOM elements.
 *
 *	The Widget class handles the element attributes.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Widget extends UIObject
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	The parent widget.
	 *	@var Widget
	 */
	protected $parent;

	/**
	 *	Child widgets
	 *	@var array
	 */
	protected $childWidgets = array();

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns the set widget, by default itself.
	 *
	 *	@return	Widget
	 */
	public function asWidget() 
	{
		return $this;
	}

	/**
	 *	Returns the parent widget.
	 *
	 *	@return	Widget
	 */
	public function getParent() 
	{
		return $this->parent;
	}

	/**
	 *	Removes it self from the parent widget.
	 *
	 *	@return	void
	 */
	public function removeFromParent() 
	{
		$this->parent->removeChild($this);
	}

	/**
	 *	Adds an attribute to the element.
	 *
	 *	@param	string	$name 
	 *	@param	string	$value
	 *	@return	this
	 */
	public function setAttribute($name, $value)
	{
		$this->initAttributeList();
		$this->attributes[$name] = $value;
		return $this;
	}

	/**
	 *	Adds an attribute to the element.
	 *
	 *	@param	string	$name 
	 *	@return	this
	 */
	public function removeAttribute($name)
	{
		if (!isset($this->attributes)) return;
		if (isset($this->attributes[$name])) unset($this->attributes[$name]);
		return $this;
	}

	/**
	 *	Initializes the Element instance. 
	 *	Appends the element attributes.
	 *
	 *	@return	void
	 */
	public function load() 
	{
		$this->appendAttributes();
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Appends the attributes, if any.
	 *
	 *	@return	void
	 */
	protected function appendAttributes() 
	{
		if (!isset($this->attributes)) return;
		foreach ($this->attributes as $name => $value) {
			$this->asWidget()->getElement()->setAttribute($name, $value);
		}
	}
}