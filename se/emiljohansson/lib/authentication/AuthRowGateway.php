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
class AuthRowGateway extends RowGateway {

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct($id = null) {
		parent::__construct('User');
		$this->record->id	= $id;
		array_push($this->protectedFields, 'password');
	}
}