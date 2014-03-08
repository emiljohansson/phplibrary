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
 * A list of Record objects, successfully collected from the database.
 *
 * A ResultSet, LinkedList inspired, stores a list of Record objects and
 * makes it easy to iterate the list.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class ResultSet {

	//----------------------------------------------------------
	// Private properties
	//----------------------------------------------------------

	/**
	 * A list of Records.
	 * @var array
	 */
	private $recordList;

	/**
	 * Points at the position in the list.
	 * @var int
	 */
	private $cursor;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes the list of Record:s and the starting point
	 * of the list for iteration use.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->recordList	= array();
		$this->cursor		= 0;
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Adds a Record to the end of the list.
	 *
	 * @param	Record	$record
	 * @return void
	 */
	public function add(Record $record) {
		array_push($this->recordList, $record);
	}

	/**
	 * Returns the number of records in the list.
	 *
	 * @return	int
	 */
	public function size() {
		return count($this->recordList);
	}

	/**
	 * Returns the record in the list where the cursor is pointing at.
	 *
	 * @return	Record
	 */
	public function get() {
		if (!$this->isValid()) return null;
		return $this->recordList[$this->cursor];
	}

	/**
	 * Moves the cursor position up one position.
	 *
	 * @return	boolean	True if there is a new row; False if the last position has passed.
	 */
	public function next() {
		if (!$this->isValid()) return false;
		$record	= $this->get();
		$this->cursor++;
		return $record;
	}

	//----------------------------------------------------------
	// Private methods
	//----------------------------------------------------------
	
	/**
	 * Returns if the cursor has passed the size of list.
	 *
	 * @return	boolean	True if there is a new row; False if the last position has passed.
	 */
	private function isValid() {
		return $this->cursor < $this->size();
	}
}