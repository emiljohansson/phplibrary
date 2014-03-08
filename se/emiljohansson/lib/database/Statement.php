<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * @copyright	Emil Johansson 2013
 * @license	http://www.opensource.org/licenses/mit-license.php MIT
 * @link		https://github.com/emiljohansson
 */

//--------------------------------------------------------------
// Public class
//--------------------------------------------------------------

/**
 * Handles SQL queries. 
 *
 * The Statement object replaces ? marks in the passed string
 * with values padded to the add() method.
 *
 * @version	0.1.0
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Statement extends DatabaseObject {

	//----------------------------------------------------------
	// Public constant properties
	//----------------------------------------------------------

	/**
	 * The folder where the exceptions are stored. 
	 * Default is set to "sql/"
	 * @var string
	 */
	const FOLDER = "sql/";

	//----------------------------------------------------------
	// Private properties
	//----------------------------------------------------------

	/**
	 * The default query. Will be modified with values passed 
	 * in the add method.
	 * @var string
	 */
	private $query;

	/**
	 * A list of Record objects, successfully collected from the database.
	 * @var ResultSet
	 */
	private $result;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Accepts SQL strings with questionmarks, which will be replaced using
	 * the add method.
	 *
	 * @param	string	$query	Example "SELECT * FROM User WHERE id = ?";
	 * @return	void
	 */
	public function __construct($query) {
		parent::__construct();
		$this->query = $query;
	}

	/**
	 * Executes the query and returns a set of records.
	 *
	 * @return	ResultSet
	 * @throws	SQLException
	 */
	public function executeQuery() {
		Log::add(self::FOLDER, $this->query);
		$this->result	= new ResultSet();
		$rs				= $this->database->query($this->query);
		if ($this->database->error) {
			throw new SQLException($this->database->error);
		}
		$this->fillResultSet($rs);
		return $this->result;
	}

	/**
	 * Executes an UPDATE, INSERT or DELETE statement and returns an integer describing the number of affected rows.
	 *
	 * @return	ResultSet
	 * @throws	SQLException
	 */
	public function executeUpdate() {
		Log::add(self::FOLDER, $this->query);
		$this->result	= new ResultSet();
		$rs				= $this->database->query($this->query);
		if ($this->database->error) {
			throw new SQLException($this->database->error);
			return;
		}
		return $this->database->affected_rows;
	}

	/**
	 * Replaces the first found (?)-mark the the query with the value.
	 *
	 * @param	mixed	$value
	 * @return void
	 */
	public function add($value) {
		$pos			= (int)strpos($this->query, '?');
		$this->query	= substr_replace($this->query, "'$value'", $pos, 1);
	}

	/**
	 * Returns The last added rows id.
	 *
	 * @return	int
	 */
	public function getInsertedId() {
		return $this->database->insert_id;
	}

	//----------------------------------------------------------
	// Private methods
	//----------------------------------------------------------

	/**
	 * Fills the ResultSet with Records.
	 *
	 * @param	mysqli_result	$sqlResult
	 * @return	void
	 */
	private function fillResultSet(mysqli_result $sqlResult) {
		while ($data = $sqlResult->fetch_assoc()) {
			$record	= $this->createRecord($data);
			$this->result->add($record);
		}
	}

	/**
	 * Creates and returns a record.
	 *
	 * @param	array	$data
	 * @return	Record
	 */
	private function createRecord($data) {
		$record	= new Record();
		foreach ($data as $key => $value) {
			$record->$key = $value;
		}
		return $record;
	}
}