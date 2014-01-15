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
 *	A collection of factory methods to create DOM elements.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
final class DOM
{
	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------
	
	/**
	 *	Appends a child to the parent.
	 *
	 *	@return	void
	 */
	public static final function appendChild(DOMNode $parent, DOMNode $child)
	{
		$parent->appendChild($child);
	}

	/**
	 *	Creates a new anchor element.
	 *
	 *	@return	Element
	 */
	public static final function createAnchor() 
	{
		return self::createElement('a');
	}

	/**
	 *	Creates a new button element.
	 *
	 *	@return	Element
	 */
	public static final function createButton() 
	{
		return self::createElement('button');
	}

	/**
	 *	Creates a new div element.
	 *
	 *	@return	Element
	 */
	public static final function createDiv() 
	{
		return self::createElement('div');
	}

	/**
	 *	Creates a new element.
	 *
	 *	@param	string	$nodeName
	 *	@param	string	$nodeValue
	 *	@return	Element
	 */
	public static final function createElement($nodeName, $nodeValue = null) 
	{
		return Document::get()->createElement($nodeName, $nodeValue);
	}

	/**
	 *	Creates a new header element.
	 *
	 *	@param	int	$num
	 *	@return	Element
	 */
	public static final function createHElement($num) 
	{
		return self::createElement("h".$num);
	}

	/**
	 *	Creates a new label element.
	 *
	 *	@return	Element
	 */
	public static final function createLabel() 
	{
		return self::createElement("label");
	}

	/**
	 *	Creates a option element.
	 *
	 *	@return	Element
	 */
	public static final function createOption()
	{
		return self::createElement('option');
	}

	/**
	 *	Creates a script element.
	 *
	 *	@return	Element
	 */
	public static final function createScript()
	{
		return self::createElement('script');
	}

	/**
	 *	Creates a select element.
	 *
	 *	@return	Element
	 */
	public static final function createSelect()
	{
		return self::createElement('select');
	}

	/**
	 *	Creates a span element.
	 *
	 *	@return	Element
	 */
	public static final function createSpan()
	{
		return self::createElement('span');
	}

	/**
	 *	Creates a tbody element.
	 *
	 *	@return	Element
	 */
	public static final function createTable()
	{
		return self::createElement('table');
	}

	/**
	 *	Creates a tbody element.
	 *
	 *	@return	Element
	 */
	public static final function createTBody()
	{
		return self::createElement('tbody');
	}

	/**
	 *	Creates a td element.
	 *
	 *	@return	Element
	 */
	public static final function createTD()
	{
		return self::createElement('td');
	}

	/**
	 *	Creates a th element.
	 *
	 *	@return	Element
	 */
	public static final function createTH()
	{
		return self::createElement('th');
	}
	
	/**
	 *	Creates a thead element.
	 *
	 *	@return	Element
	 */
	public static final function createTHead()
	{
		return self::createElement('thead');
	}

	/**
	 *	Creates a tr element.
	 *
	 *	@return	Element
	 */
	public static final function createTR()
	{
		return self::createElement('tr');
	}
}