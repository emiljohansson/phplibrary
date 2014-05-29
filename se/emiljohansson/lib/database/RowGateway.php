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

//-----------------------------------------------------------------
// Public class
//-----------------------------------------------------------------

/**
 * A gateway for collecting and modifying single rows in selected database table.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class RowGateway extends Gateway {

	//----------------------------------------------------------
	// Protected properties
	//----------------------------------------------------------

	/**
	 * Some fields should not be able to be updated, such as the Primary key.
	 * @var array
	 */
	protected $protectedFields = array('id');

	/**
	 * The record based on the database table, matching each field.
	 * @var Record
	 */
	protected $record;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes the database object and what table to connect to.
	 *
	 * @param	string	$tableName
	 * @return	void
	 */
	public function __construct($tableName) {
		parent::__construct($tableName);
		$this->record = new Record();
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Returns the record.
	 *
	 * @return	Record
	 */
	public function getRecord() {
		return $this->record;
	}

	/**
	 * Sets the record.
	 *
	 * @param	Record	$aRecord;
	 * @return	void
	 */
	public function setRecord(Record $aRecord) {
		$this->record = $aRecord;
	}

	/**
	 * Sets the records public data based on the values in the param.
	 *
	 * @param	array	$data
	 * @return	Record
	 */
	public function setRecordData($data) {
		foreach ($data as $key => $value) {
			if ($key == $this->primaryKey) {
				if (!isset($this->record->id)) {
					$this->record->$key = $value;
				}
			}
			else {
				$this->record->$key = $value;
			}
		}
		return $this->record;
	}

	/**
	 * Returns an array, containing all fields from the model.
	 *
	 * @return	array
	 */
	public function toArray() {
		return (array)$this->record;
	}

	/**
	 * Removes a row from the database table.
	 *
	 * @return	int	The number of affected rows.
	 * @throws	SQLException
	 */
	public function remove() {
		$query		= "DELETE FROM ".$this->table." WHERE ".$this->primaryKey." = ?";
		$statement	= new Statement($query);
		$statement->add($this->record->id);
		try {
			return $statement->executeUpdate();
		}
		catch (SQLException $e) {
			throw $e;
		}
	}

	/**
	 * Either updates or inserts a new row to the database.
	 *
	 * @return	Response
	 */
	public function save() {
		$recordArr = $this->toArray();
		if (!isset($recordArr[$this->primaryKey])) {
			return $this->insert();
		}
		return $this->update();
	}

	//----------------------------------------------------------
	// Protected methods
	//----------------------------------------------------------

	/**
	 * Inserts a new row to the database table.
	 *
	 * @todo	refactor
	 * @return	Response
	 */
	protected function insert() {
		$arr		= $this->toArray();
		$response	= new Response();
		$query		= "INSERT INTO ".$this->table;
		if (count($arr) < 1) {
			$arr[$this->primaryKey] = "NULL";
		}
		if (count($arr) === 1 && array_key_exists('id', $arr)) {
			$query .= "(".$this->primaryKey.") VALUES (NULL)";
			if ($this->database->query($query)) {
				$pk					= $this->primaryKey;
				$this->record->$pk	= $this->database->insert_id;
			}
			$response->add($this->toArray());
			return $response;
		}

		$query	.= " (";

		foreach ($arr as $key => $value) {
			if (!in_array($key, $this->protectedFields)) {
				$query .= $key.",";
			}
		}

		$query = substr_replace($query, ") ", -1);
		$query .= "VALUES (";

		foreach ($arr as $key => $value) {
			if (!in_array($key, $this->protectedFields)) {
				if ($value === null && $value !== "0") {
					$query .= "NULL,";
				}
				else {
					$query .= "'".$value."',";
				}
			}
		}

		$query = substr_replace($query, ") ", -1);

		try {
			$this->executeStatement($query, "Insert");
		}
		catch (SQLException $e) {
			$response->setStatusToError($e->message());
		}

		$pk					= $this->primaryKey;
		$this->record->$pk	= $this->database->insert_id;
		$response->add($this->toArray());
		return $response;
	}

	/**
	 * Updates a row in the database table.
	 *
	 * @return	boolean		Query success
	 */
	protected function update() {
		$arr	= $this->toArray();
		$query	= "UPDATE ".$this->table." SET ";
		foreach ($this->toArray() as $key => $value) {
			if (isset($value) && !in_array($key, $this->protectedFields)) {
				$query .= $key." = '".$value."', ";
			}
		}

		$query = substr($query, 0, count($query)-3);
		$query .= " WHERE ".$this->primaryKey." = ".$arr[$this->primaryKey];
		
		$this->executeStatement($query, "Update");
		
		$response	= new Response();
		$response->add($this->toArray());
		return $response;
	}

	//----------------------------------------------------------
	// Private methods
	//----------------------------------------------------------

	/**
	 * Executes a statement.
	 *
	 * @param	string	$query
	 * @param	string	$type	For the error text, I.e. upate or insert
	 * @throws	SQLException
	 */
	private function executeStatement($query, $type = "Query") {
		$statement	= new Statement($query);
		try {
			$statement->executeUpdate();
		}
		catch (SQLException $e) {
			throw $e;
		}
	}
}