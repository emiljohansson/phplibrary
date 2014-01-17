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
 *	An exception that occured concerning the Application.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class ApplicationException extends BaseException 
{
	//-----------------------------------------------------------
	//	Public static constant properties
	//-----------------------------------------------------------

	/**
	 *	The location where the message should be placed.
	 *	@var string
	 */
	const FOLDER = 'application/';

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes where to store the message.
	 *
	 *	@param	string	$errorMessage
	 *	@param	int		$code
	 *	@return	void
	 */
	public function __construct($errorMessage, $code = 1) 
	{
		parent::__construct(self::FOLDER, $errorMessage);
		$this->code = $code;
	}
}