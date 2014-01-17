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
 *	Logs messages, such as exceptions.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 *	@todo		Remove application dependent code.
 */
class Log 
{
	//-----------------------------------------------------------
	//	Constant properties
	//-----------------------------------------------------------

	/**
	 *	The location where the message should be placed.
	 *	@var string
	 */
	const PATH = './var/';

	//-----------------------------------------------------------
	//	Public static properties
	//-----------------------------------------------------------

	/**
	 *	If true, a separate file will be added for unit testing.
	 *	@var boolean
	 */
	public static $isUnitTesting = false;

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Creates a file for the current date and adds the message
	 *	to the bottom of the file.
	 *
	 *	@param	string	$folder		Where to store the message.
	 *	@param	string	$message	Message that will be stored at 
	 *								the bottom of the file.
	 *	@return	void
	 *	@todo	Remove user specific code.
	 */
	public static function add($folder, $message) 
	{
		self::fixFolder($folder);
		$path = self::$isUnitTesting? self::PATH.'test/' : self::PATH;

		date_default_timezone_set('Europe/Stockholm');
		$date	= date("Y-m-d");
		$time	= date("h:i:s A", time());

		$filename	= ($date.".log");
		$fullpath	= $path.$folder.$filename;
		$fullMessage	= $time.'
'.$message.'

';
		if (!is_dir($fullpath)) return;
		error_log($fullMessage, 3, $fullpath);
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Modifies the folder name. Override this method if the application 
	 *	wants to store logs in a specific folder.
	 *
	 *	@param	string	$folder
	 *	@return	void
	 */
	protected static function fixFolder(&$folder) 
	{
		if (method_exists(Session::$engine, "getUser")) {
			self::userFolder($folder);
			return;
		}
	}

	/**
	 *	Updates the folder to be named after the signed in users id.
	 *
	 *	@param	string	$folder
	 *	@return	void
	 *	@todo	Refactor to a possible sub-class.
	 */
	protected static function userFolder(&$folder)
	{
		$user = Session::$engine->getUser();
		if (!isset($user)) return;
		if (!array_key_exists('id', $user)) return;
		$folder .= $user->id.'_';
	}
}