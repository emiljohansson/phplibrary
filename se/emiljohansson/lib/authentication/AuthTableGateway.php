<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * @copyright	Emil Johansson 2013
 * @license		http://www.opensource.org/licenses/mit-license.php MIT
 * @link				https://github.com/emiljohansson
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
class AuthTableGateway extends TableGateway {

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct('User');
		$this->rowGatewayClass = "AuthRowGateway";
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Compare the fields in the database with the user object 
	 * and return a possible match.
	 *
	 * @param	Record	$user
	 * @return	UserRowGateway | null
	 */
	public function match(Record $user) {
		if (!isset($user->email)) return null;
		if (!isset($user->password)) return null;

		$query	= $this->defaultQuery." WHERE ";
		foreach ($user as $key => $value) {
			if (isset($value)) {
				if ($key === 'password') {
					$query .= $key." = PASSWORD('".$value."') AND ";
				}
				else {
					$query .= $key." = '".$value."' AND ";
				}
			}
		}
		$query = substr($query, 0, count($query)-5);
		$query .= " LIMIT 1";

		$list	= $this->get($query);
		if (count($list) > 0) {
			return $list[0];
		}
		return null;
	}
}