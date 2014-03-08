<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * Inspired by the GWT library <http://www.gwtproject.org/>
 *
 * @copyright	Emil Johansson 2013
 * @license		http://www.opensource.org/licenses/mit-license.php MIT
 * @link		https://github.com/emiljohansson
 */

//--------------------------------------------------------------
// Public class
//--------------------------------------------------------------

/**
 * summary...
 *
 * description...
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Input extends Widget {

	//----------------------------------------------------------
	// Protected properties
	//----------------------------------------------------------

	/**
	 * ...
	 * @var string
	 */
	protected $type = "text";
	
	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @param	string	$value
	 * @return void
	 */
	public function __construct($value = "") {
		parent::__construct();
		$this->setElement(DOM::createElement('input'));
		$this->setAttribute("value", $value);
		$this->setAttribute("type", $this->type);
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * ...
	 *
	 * @param	string	$value
	 * @return	Widget
	 */
	public function setType($value) {
		return $this->setAttribute('type', $value);
	}

	/**
	 * ...
	 *
	 * @param	string	$value
	 * @return	Widget
	 */
	public function setName($value) {
		return $this->setAttribute('name', $value);
	}
}