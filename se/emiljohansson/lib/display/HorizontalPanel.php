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
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class HorizontalPanel extends Panel {

	//----------------------------------------------------------
	// Private properties
	//----------------------------------------------------------

	/**
	 * ...
	 * @var TableRow
	 */
	private $row;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setElement(DOM::createTable());
		$this->row = new TableRow();
		parent::add($this->row);
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Adds a widget to the document body.
	 *
	 * @param	Widget	$widget
	 * @return	void
	 */
	public function add(Widget $widget) {
		$td	= new TableCell();
		$td->add($widget);
		$this->row->add($td);
	}
}