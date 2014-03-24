<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * Inspired by the GWT library <http://www.gwtproject.org/>
 *
 * @copyright	Emil Johansson 2013
 * @license	http://www.opensource.org/licenses/mit-license.php MIT
 * @link		https://github.com/emiljohansson
 */

//-----------------------------------------------------------
// Public class
//-----------------------------------------------------------

/**
 * summary...
 *
 * description...
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Hidden extends Input {

	//-----------------------------------------------------------
	// Constructor method
	//-----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @param	string	$value
	 * @param	string	$name
	 * @return	void
	 */
	public function __construct($value = "", $name = "") {
		parent::__construct($value);
		$this->setType('hidden');
		$this->setAttribute('name', $name);
	}
}