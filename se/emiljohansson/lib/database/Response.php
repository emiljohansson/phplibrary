<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * @copyright	Emil Johansson 2013
 * @license		http://www.opensource.org/licenses/mit-license.php MIT
 * @link		https://github.com/emiljohansson
 */

//-------------------------------------------------------------
// Public class
//-------------------------------------------------------------

/**
 * Stores the data from a gateway and if the query was successful.
 *
 * Effective for API use and presenting JSON data. The response 
 * returns an object containing two arrays; a head part for the status
 * and a body part for the data and possible error message.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Response extends DatabaseObject {

	//---------------------------------------------------------
	// Private properties
	//---------------------------------------------------------

	/**
	 * The active status of a database query. Default status is 1.
	 * @var int
	 */
	private $status;

	/**
	 * The head part of the data contains information not important to be presented to the user.
	 * @var array
	 */
	private $head;

	/**
	 * The body part of the data contains information to be presented to the user.
	 * @var array
	 */
	private $body;

	//---------------------------------------------------------
	// Constructor method
	//---------------------------------------------------------

	/**
	 * Initializes status, head and body.
	 * 
	 * @return	void
	 */
	public function __construct() {
		parent::__construct();
		$this->status	= 1;
		$this->head		= array();
		$this->body		= array();
	}

	//---------------------------------------------------------
	// Public methods
	//---------------------------------------------------------

	/**
	 * Prints out the status and record.
	 *
	 * @return	array
	 */
	public function get() {
		$this->checkError();
		$this->head['status']	= $this->status;
		return $this->asObject();
	}

	/**
	 * Returns an array, containing all fields from the model.
	 *
	 * @return	array
	 */
	public function toArray() {
		$data = array();
		$this->checkError();
		$this->head['status']	= $this->status;
		$data['head']			= $this->head;
		$data['body']			= $this->body;
		return $data;
	}

	/**
	 * Returns a json object based on the data array.
	 *
	 * @return	Object
	 */
	public function toJson() {
		return json_encode($this->toArray());
	}

	/**
	 * Adds all the keys and values from the parameter array to data.
	 *
	 * @param	array	$data
	 * @return	void
	 */
	public function add(array $data, $asArray = false) {
		if ($asArray) {
			array_push($this->body, $data);
			return;
		}
		foreach ($data as $key => $value) 
		{
			$this->body[$key] = $value;
		}
	}

	/**
	 * Sets the status to error.
	 *
	 * @param	string	errorMsg
	 * @return void
	 */
	public function setStatusToError($errorMsg) {
		$this->status	= 0;
		$this->body['message']	= $errorMsg;
	}

	/**
	 * Returns if status is set to successful.
	 *
	 * @return	boolean
	 */
	public function wasSuccessful() {
		$this->checkError();
		return $this->status == 1;
	}

	/**
	 * Returns a value from a key in the body.
	 *
	 * @return	mixed
	 */
	public function getKeyValue($key) {
		$obj	= $this->get();
		return $obj->body->$key;
	}

	//---------------------------------------------------------
	// Private methods
	//---------------------------------------------------------

	/**
	 * Converts all values to an object.
	 *
	 * @return	stdClass
	 */
	private function asObject() {
		$data = new stdClass();

		$headObj = new stdClass();
		foreach ($this->head as $key => $value) 
		{
			$headObj->$key = $value;
		}
		$data->head = $headObj;

		$bodyObj = new stdClass();
		foreach ($this->body as $key => $value) 
		{
			$bodyObj->$key = $value;
		}
		$data->body = $bodyObj;

		return $data;
	}

	/**
	 * Adds possible error message from the database.
	 *
	 * @return void
	 */
	private function checkError() {
		if ($this->status === 0) return;
		if (!$this->database->error) 
		{
			unset($this->body['message']);
			return;
		}
		$this->status			= 0;
		$this->body['message']	= $this->database->error;
	}
}