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
 *	A session object for handling the time the user spends on the applciation.
 *
 *	The class starts, ends and stores data in the superglobal property $_SESSION.
 *	It also hold an instance of an Engine object.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Session
{
	//-----------------------------------------------------------
	//	Public static properties
	//-----------------------------------------------------------

	/**
	 *	A reference to the Engine.
	 *	@var Engine
	 */
	public static $engine;

	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	Singular object.
	 *	@var Database
	 */
	private static $instance;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Initializes the session.
	 *
	 *	@return	void
	 */
	public static function init(Engine $engine) 
	{
		self::$instance	= new Session();
		self::$engine		= $engine;
		self::$engine->session	= self::$instance;
		self::$instance->start();
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Start a new session.
	 *
	 *	@return	void
	 */
	public final function start() 
	{
		if (isset($_SESSION)) return;
		session_start();
	}

	/**
	 *	Destroys the current session.
	 *
	 *	@return void
	 */
	public final function destroy() 
	{
		session_destroy();
	}

	/**
	 *	Sets a value in the global $_SESSION property.
	 *
	 *	@param	string	$property
	 *	@param	mixed	$value
	 *	@return	void
	 */
	public final function set($property, $value) 
	{
		$_SESSION[$property] = $value;
	}

	/**
	 *	Returns a value from the global $_SESSION property.
	 *
	 *	@param	string	$property
	 *	@return	mixed
	 */
	public final function get($property) 
	{
		if (isset($_SESSION[$property])) return $_SESSION[$property];
		return null;
	}
}