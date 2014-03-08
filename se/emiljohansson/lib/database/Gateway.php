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
 * Base for TableGateway and RowGateway.
 *
 * Stores the primary id and the name of the database table.
 *
 * @internal	
 * @version		0.1.0
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
abstract class Gateway extends DatabaseObject {

	//----------------------------------------------------------
	// Public properties
	//----------------------------------------------------------

	/**
	 * The primary key field, default is set to id.
	 * @var string
	 */
	public $primaryKey = 'id';

	//----------------------------------------------------------
	// Protected properties
	//----------------------------------------------------------

	/**
	 * The table in the database related to this gateway. 
	 * @var string
	 */
	protected $table;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes the database object and what table to connect to.
	 *
	 * @param	string	$tableName
	 * @return void
	 */
	public function __construct($tableName) {
		parent::__construct();
		$this->table = $tableName;
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Returns the table in the database related to this gateway.
	 *
	 * @return	string
	 */
	public function getTableName() {
		return $this->table;
	}
}