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

//--------------------------------------------------------------
// Public class
//--------------------------------------------------------------

/**
 * Creates content in a vertical alignment.
 *
 * Adding to a vertical panel will keep the content in a row.
 *
 * @version	0.1.0
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class VerticalPanel extends Panel {

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes a table element.
	 * 
	 * @return void
	 */
	public function __construct() 
	{
		parent::__construct();
		$this->setElement(DOM::createTable());
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
		$tr	= new TableRow();
		$td	= new TableCell();
		$td->add($widget);
		$tr->add($td);
		parent::add($tr);
	}
}