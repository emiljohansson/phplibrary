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
 * A gateway for collecting and modifying all rows in selected database table.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 * @todo	Replace query strings with Statements
 */
class TableGateway extends Gateway {

	//----------------------------------------------------------
	// Private static properties
	//----------------------------------------------------------

	/**
	 * Stores arrays containing each pulled row.
	 * @var array
	 */
	private static $listOfRows = array();

	/**
	 * Should be changed if all records has been loaded.
	 * @var boolean
	 */
	private static $allLoaded = array();

	//----------------------------------------------------------
	// Private static methods
	//----------------------------------------------------------

	/**
	 * Adds a row gateway if its not there.
	 *
	 * @param	RowGateway	$row
	 * @return	void
	 */
	protected static function addToList(RowGateway $row) {
		$tableName = $row->getTableName();
		if (!isset(self::$listOfRows[$tableName])) {
			self::$listOfRows[$tableName] = array();
		}
		if (!in_array($row, self::$listOfRows[$tableName])) {
			array_push(self::$listOfRows[$tableName], $row);
		}
	}

	/**
	 * Returns a row gateway if the id is matches one in the list.
	 *
	 * @param	int		$int
	 * @param	string	$tableName
	 * @param	string	$primaryKey
	 * @return	RowGateway
	 */
	protected static function findInList($id, $tableName, $primaryKey) {
		if (!isset(self::$listOfRows[$tableName])) return null;
		foreach (self::$listOfRows[$tableName] as $row) {
			if ($id == $row->getRecord()->$primaryKey)
				return $row;
		}
		return null;
	}

	//----------------------------------------------------------
	// Protected properties
	//----------------------------------------------------------

	/**
	 * The default query retrieves all rows, with all fields.
	 * @var string
	 */
	protected $defaultQuery;

	/**
	 * The row gateway used by the table.
	 * @var RowGateway
	 */
	protected $rowGatewayClass;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes the default query and row gateway class.
	 *
	 * @param	string	$tableName
	 * @return	void
	 */
	public function __construct($tableName) {
		parent::__construct($tableName);
		$this->defaultQuery		= "SELECT * FROM ".$tableName;
		$this->rowGatewayClass	= "RowGateway";
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Returns a row based on id.
	 *
	 * @param	int		$id
	 * @return	RowGateway
	 * @throws	SQLException
	 */
	public function findById($id) {
		$query	= $this->defaultQuery." WHERE ".$this->primaryKey." = ".$id." LIMIT 1";
		$list;
		try {
			$list	= $this->get($query);
		}
		catch (SQLException $e) {
			throw $e;
		}
		if (count($list) > 0) 
			return $list[0];
		return null;
	}

	/**
	 * Find a row based on the key and its value.
	 *
	 * @param	string	$key
	 * @param	string	$value
	 * @return	RowGateway
	 */
	public function findByKey($key, $value) {
		$query	= $this->defaultQuery." WHERE ".$key." IN ('".$value."') LIMIT 1";
		$list	= $this->get($query);
		if (count($list) > 0)
			return $list[0];
		return null;
	}

	/**
	 * Returns all rows in the database. Each item is a RowGateway.
	 *
	 * @param	string|null	$query
	 * @return	ResultSet
	 * @throws	SQLException
	 */
	public function get($query = null) {
		$q			= isset($query) ? $query : $this->defaultQuery." ORDER BY ".$this->primaryKey;
		$statement	= new Statement($q);
		$resultSet	= null;
		try {
			$resultSet	= $statement->executeQuery();
		}
		catch (SQLException $e) {
			throw $e;
		}
		$list	= array();
		while ($record = $resultSet->next()) {
			$rowGateway = $this->getRowGatewayObject();
			$rowGateway->setRecord($record);
			if (isset($query)) self::addToList($rowGateway);
			array_push($list, $rowGateway);
		}
		return $list;
	}

	//----------------------------------------------------------
	// Protected methods
	//----------------------------------------------------------

	/**
	 * Creates and returns a RowGateway.
	 *
	 * @return	RowGateway
	 */
	protected function getRowGatewayObject() {
		return new $this->rowGatewayClass($this->table);
	}
}