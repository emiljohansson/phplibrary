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

//--------------------------------------------------------------
// Public class
//--------------------------------------------------------------

/**
 * ...
 *
 * @version	0.1.1
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class AuthModel extends Model {

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct() {
		$this->gateway			= new AuthTableGateway();
		$this->rowGatewayClass	= "AuthRowGateway";
		$this->tableName		= "User";
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Calls the gateway to find out 
	 * if a match of username and password is found.
	 *
	 * @param	string	username
	 * @param	string	password
	 * @param	Record || null
	 */
	public  function attempt($username, $password) {
		$user			= new Record();
		$user->username	= $username;
		$user->password	= $password;
		$row = $this->gateway->match($user);
		if (!isset($row)) return null;
		return $row->getRecord();
	}
}