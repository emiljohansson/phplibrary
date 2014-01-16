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
 *	A class to check if the project is localhosted.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Host
{
	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	Singular object.
	 *	@var Host
	 */
	private static $instance;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Returns a singleton instance of the class.
	 *
	 *	@return	Host
	 */
	public static function get() 
	{
		if (!isset(self::$instance)) self::$instance = new Host();
		return self::$instance;
	}

	//-----------------------------------------------------------
	//	Private properties
	//-----------------------------------------------------------
	
	/**
	 *	A list of possible localhosts.
	 *	@var array
	 */
	private $whitelist = array('localhost', '127.0.0.1');

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns true if the project is placed in localhost.
	 *
	 *	@return	boolean
	 */
	public function isLocalhost() 
	{
		return in_array($_SERVER['HTTP_HOST'], $this->whitelist);
	}
}