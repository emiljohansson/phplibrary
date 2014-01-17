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
 *	An exception that occured handling SQL queries.
 *
 *	The SQLException stores the message under the sql folder.
 *	The object will also generate a better response for the end user.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class SQLException extends BaseException 
{
	//-----------------------------------------------------------
	//	Public constant properties
	//-----------------------------------------------------------

	/**
	 *	The location where the message should be placed.
	 *	@var string
	 */
	const FOLDER = 'sql/';

	/**
	 *	A foreign key error occured, meaning an id for the foreign table
	 *	is either not set or is not matching any id in the foreign table.
	 *	@var int
	 */
	const CODE_FOREIGN_KEY = 1;

	/**
	 *	The code for if a column has been set to null where its not allowed.
	 *	@var int
	 */
	const CODE_NULL = 2;

	/**
	 *	If a value already exist and has to be unique.
	 *	@var int
	 */
	const CODE_DUPLICATE = 3;

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes where to store the message and checks if the
	 *	message is one of the special cases.
	 *
	 *	@param	string	$errorMessage
	 *	@return void
	 */
	public function __construct($errorMessage) 
	{
		parent::__construct(self::FOLDER, $errorMessage);
		$this->updateCode($errorMessage);
	}

	/**
	 *	Returns either the default message or an modified version.
	 *
	 *	@return	string
	 */
	public function message() 
	{
		if ($this->code != 0) {
			return $this->getModifiedMessage();
		}
		return parent::getMessage();
	}

	//-----------------------------------------------------------
	//	Private methods
	//-----------------------------------------------------------

	/**
	 *	Updates the code to match one of the possible special cases.
	 *
	 *	@param	string	$msg
	 *	@return	void
	 */
	private function updateCode($msg) 
	{
		if (strstr($msg, "Cannot add or update a child row: a foreign key constraint fails")) {
			$this->code	= self::CODE_FOREIGN_KEY;
		}
		else if (strstr($msg, "' cannot be null")) {
			$this->code	= self::CODE_NULL;
		}
		else if (strstr($msg, "Duplicate entry ")) {
			$this->code = self::CODE_DUPLICATE;
		}
	}

	/**
	 *	Parses the error message and gives a better response.
	 *
	 *	The message can handle missing, empty and duplicate properties, 
	 *	otherwise the standard message will be returned.
	 *
	 *	@param	string	$errorMessage
	 *	@return	string	A string with the first character of message capitalized.
	 */
	private function getModifiedMessage() 
	{
		$message = "";
		switch ($this->code) {

			case self::CODE_FOREIGN_KEY:
				$pattern = "/REFERENCES `(.*)` /";
				preg_match($pattern , $this->message, $matches);
				$message = $matches[1]." was missing or incorrect";
				break;

			case self::CODE_NULL:
				$pattern = "/Column '(.*)' cannot be null/";
				preg_match($pattern , $this->message, $matches);
				$message = $matches[1]." cannot be empty";
				break;

			case self::CODE_DUPLICATE:
				$pattern = "/Duplicate entry '(.*)' for key '(.*)'/";
				preg_match($pattern , $this->message, $matches);
				$message = $matches[2].": ".$matches[1]." already exist";
				break;

			default:
				$message = parent::getMessage();
				break;

		}
		$message = ucfirst($message);
		return $message;
	}
}