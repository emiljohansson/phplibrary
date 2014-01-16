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
 *	The root panel for adding visible content to the user.
 *
 *	Keeps a singleton instance of the body tag. Adding to this
 *	panel will append children to the end of the body tag.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
final class RootPanel extends SimplePanel
{
	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	A singleton object.
	 *	@var RootPanel
	 */
	private static $instance;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Returns the instance of the panel.
	 *	If id is set, the method will return a node matching the id.
	 *
	 *	@param	string	$id
	 *	@return	RootPanel
	 */
	public static function get($id = null) 
	{
		if (!isset(self::$instance)) self::$instance = new RootPanel();
		if (isset($id)) return self::getBodyElement()->getElementById($id);
		return self::$instance;
	}

	/**
	 *	Returns the body node.
	 *
	 *	@return	Element
	 */
	public static function getBodyElement()
	{
		return Document::get()->getBody();
	}

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes the body tag.
	 *	
	 *	@return void
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->setElement(self::getBodyElement());
	}
}