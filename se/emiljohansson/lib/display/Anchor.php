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
class Anchor extends Panel {
	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @param	string	$content
	 * @param	string	$href
	 * @return void
	 */
	public function __construct($content = "", $href = "") {
		parent::__construct();
		$this->setElement(DOM::createElement('a'));
		$this->getElement()->setInnerHTML($content);
		$this->setAttribute("href", $href);
	}
}