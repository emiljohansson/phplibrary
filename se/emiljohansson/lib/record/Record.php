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
 * A representation of a record in the database.
 *
 * The record based on a table, containing each field.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Record {

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Creates public variables for each key in the array.
	 *
	 * @param	array	$arr
	 * @return	void
	 */
	public function convert(array $arr) {
		foreach ($arr as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * Removes a variable from this object and moves it to 
	 * the parameter record.
	 *
	 * @param	Record	$record
	 * @param	string	$key
	 * @return	void
	 */
	public function transfer(Record &$record, $key) {
		$record->$key = $this->splice($key);
	}

	/**
	 * Removes a variable and returns its value.
	 *
	 * @param	string	$key
	 * @return	mixed
	 */
	public function splice($key) {
		$tempValue = $this->$key;
		unset($this->$key);
		return $tempValue;
	}

	/**
	 * Returns all values as an array.
	 *
	 * @return	array
	 */
	public function toArray() {
		return (array)$this;
	}
}