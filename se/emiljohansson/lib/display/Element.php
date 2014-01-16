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
 *	Base of all DOM elements.
 *
 *	The Element class handles the appendens of new child nodes and 
 *	makes it possible to update the inner html of the node.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Element extends Node
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	Attributes will be added to the element after it has been appended.
	 *	@var array
	 */
	protected $attributeList;

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Appends a node to the element.
	 *
	 *	@param	DOMNode	$newnode
	 *	@return	DOMNode
	 */
	public function appendChild(DOMNode $newnode) 
	{
		parent::appendChild($newnode);
		if (isset($this->attributeList)) {
			foreach ($this->attributeList as $attribute) {
				Console::log($attribute);
				parent::setAttribute($attribute[0], $attribute[1]);
			}
		}
		return $newnode;
	}
	
	/**
	 *	Sets the innerHTML.
	 *
	 *	@param	string	$html
	 *	@return	void
	 */
	public function setInnerHTML($html)
	{
		$this->nodeValue = $html;
		return $this;
	}
}