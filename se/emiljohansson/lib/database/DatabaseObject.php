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
 * Base for all classes with database connection.
 *
 * DatabaseObject retrieve the instance of the Database object.
 *
 * @internal	
 * @version		0.1.0
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
abstract class DatabaseObject {

	//----------------------------------------------------------
	// Protected properties
	//----------------------------------------------------------

	/**
	 * A database instance.
	 * @var Database
	 */
	protected $database;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes the database property.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->database	= Database::instance();
	}
}