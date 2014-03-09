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

//-----------------------------------------------------------
// Public class
//-----------------------------------------------------------

/**
 * Simple image element.
 *
 * @version	0.1.5
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Image extends Widget {

	//-----------------------------------------------------------
	// Constructor method
	//-----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @param	String	$src
	 * @param	String	$alt
	 * @return	void
	 */
	public function __construct($src, $alt = "") {
		parent::__construct();
		$this->setElement(DOM::createElement('img'));
		$this->setAttribute("src", $src);
		$this->setAttribute("alt", $alt);
	}
}