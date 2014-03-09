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
class FormPanel extends SimplePanel {

	//----------------------------------------------------------
	// Public constant properties
	//----------------------------------------------------------

	/**
	 * POST request method.
	 * @var string
	 */
	const METHOD_POST = "POST";

	/**
	 * GET request method.
	 * @var string
	 */
	const METHOD_GET = "GET";

	/**
	 * DELETE request method.
	 * @var string
	 */
	const METHOD_DELETE = "DELETE";

	/**
	 * PUT request method.
	 * @var string
	 */
	const METHOD_PUT = "PUT";

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct(DOM::createElement('form'));
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
	public function setAction($value) {
		return $this->setAttribute('action', $value);
	}

	/**
	 * ...
	 *
	 * @param	string	$method
	 * @return	Widget
	 */
	public function setMethod($method) {
		return $this->setAttribute('method', $method);
	}
}