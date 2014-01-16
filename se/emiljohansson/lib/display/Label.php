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
 *	A representation of a label. Creates a div tag.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Label extends Widget
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	...
	 *	@var string
	 */
	protected $type = 'div';

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	...
	 *	
	 *	@param	string	$content
	 *	@return void
	 */
	public function __construct($content = "") 
	{
		parent::__construct();
		$this->setElement(DOM::createElement($this->type));
		$this->getElement()->setInnerHTML($content);
	}
}