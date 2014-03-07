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
		$this->gateway					= new AuthTableGateway();
		$this->rowGatewayClass	= "AuthRowGateway";
		$this->tableName				= "User";
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Calls the gateway to find out 
	 * if a match of email and password is found.
	 *
	 * @param	string	email
	 * @param	string	password
	 * @param	Record || null
	 */
	public  function attempt($email, $password) {
		$user			= new Record();
		$user->email	= $email;
		$user->password	= $password;
		$row = $this->gateway->match($user);
		if (!isset($row)) return null;
		return $row->getRecord();
	}
}