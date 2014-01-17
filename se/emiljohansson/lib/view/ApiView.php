<?php

/**
 *	{LIBRARY_NAME}
 *
 *	PHP Version 5.3
 *
 *	@copyright	Emil Johansson 2013
 *	@license		http://www.opensource.org/licenses/mit-license.php MIT
 *	@link				https://github.com/emiljohansson
 */

//-----------------------------------------------------------
//	Public class
//-----------------------------------------------------------

/**
 *	A special view for presenting JSON format data.
 *
 *	Uses the Response object to present data in a API friendly
 *	format and makes it easy to add objects and set the call
 *	to present errors.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class ApiView extends View
{
	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	If an an update has been made in the database,
	 *	this object can be set and will therefor be printed out.
	 *	@var Response
	 */
	public $response;

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes a special Widget and create an instance of a Response object.
	 *	
	 *	@return void
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->response = new Response();
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Sets a custom response.
	 *
	 *	@param	Response	$response
	 *	@return	void
	 */ 
	public function setResponse(Response $response) 
	{
		$this->response = $response;
	}

	/**
	 *	Adds a string or array to the output. If the second
	 *	parameter is set to true, the object will be stored
	 *	in a new array.
	 *
	 *	@param	string|array	$obj
	 *	@param	boolean			$asArray
	 *	@return	void
	 */
	public function addObject($obj, $asArray = false) 
	{
		$this->response->add($obj, $asArray);
	}

	/**
	 *	Sets the status to error.
	 *
	 *	@param	string	$errorMsg
	 *	@return void
	 */
	public function setStatusToError($errorMsg) 
	{
		$this->response->setStatusToError($errorMsg);
	}

	/**
	 *	Returns the response in JSON format.
	 *
	 *	@return	void
	 */
	public function render() 
	{
		return $this->response->toJson();
	}

	/**
	 *	Calling the method will set the Response to the default
	 *	error message.
	 *
	 *	@return void
	 */
	public function apiMissmatch() 
	{
		$this->setStatusToError("The call does not match the API");
	}

	//-----------------------------------------------------------
	//	Private methods
	//-----------------------------------------------------------

	/**
	 *	Fills the output body with either error messages or data.
	 *
	 *	@param	array	$body
	 *	@param	array	$content
	 *	@return void
	 */
	private function fillBody(array &$body, array $list = null) 
	{
		foreach ($list as $key => $value) {
			array_push($body, $value);
		}
	}
}