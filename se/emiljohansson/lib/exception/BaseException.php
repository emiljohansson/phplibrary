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
 *	The base for the library exceptions.
 *
 *	Stores all exceptions in the "exceptions" folder.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 *	@todo		Remove project specific code
 */
class BaseException extends Exception 
{
	//-----------------------------------------------------------
	//	Constant properties
	//-----------------------------------------------------------

	/**
	 *	The folder where the exceptions are stored.
	 *	@var string
	 */
	const FOLDER = 'exceptions/';

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Logs the exception and where to store it.
	 *
	 *	@param	string	$errorMessage
	 *	@return	void
	 */
	public function __construct($folder, $errorMessage) 
	{
		parent::__construct($errorMessage);
		Log::add((self::FOLDER.$folder), $errorMessage);
	}
}