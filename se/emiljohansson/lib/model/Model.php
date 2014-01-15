<?php

/**
 *	{LIBRARY_NAME}
 *
 *	PHP Version 5.3
 *
 *	@copyright	Emil Johansson 2013
 *	@license	http://www.opensource.org/licenses/mit-license.php MIT
 *	@link		https://github.com/emiljohansson
 */

//-----------------------------------------------------------
//	Public class
//-----------------------------------------------------------

/**
 *	The only accessible connection to retrieving data from the database.
 *
 *	Initializes an instance of a TableGateway object, in order to collect 
 *	data from the database.
 *
 *	The model is capable of retrieving, updating, inserting and removing 
 *	data for the database.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Model
{
	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	The table in the database related to this gateway. 
	 *	@var string
	 */
	protected $tableName;

	/**
	 *	A gateway between the database table and this model.
	 *	Handling the data for retrieving all records.
	 *	@var TableGateway
	 */
	protected $gateway;

	/**
	 *	Specifes the TableGateway the model will use. 
	 *	@var string
	 */
	protected $rowGatewayClass;

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializs an instance of the TableGateway class.
	 *	
	 *	@param	string $tableGatewayClass
	 *	@return	void
	 *	@throws	Exception	If the table name is not specified.
	 */
	public function __construct($tableName) 
	{
		if (!isset($tableName)) {
			throw new Exception("Error Table name is not defined", 1);
		}

		$this->tableName				= $tableName;
		$this->gateway					= new TableGateway($tableName);
		$this->rowGatewayClass	= "RowGateway";
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns the name of the database table.
	 *
	 *	@return	string
	 */
	public function getTableName() 
	{
		return $this->tableName;
	}

	/**
	 *	Inserts/Updates a database record. To update a record,
	 *	specify the primary id in the record. If no id is set, 
	 *	a new record will be stored in the database.
	 *
	 *	@param	Record	$record
	 *	@return	Response
	 */
	public function save($record) 
	{
		$row	= new RowGateway($this->tableName);
		$row->setRecordData($record);
		try {
			return $row->save();				
		} catch (SQLException $e) {
			$response	= new Response();
			$response->setStatusToError($e->getMessage());
			return $response;
		}
	}

	/**
	 *	Returns an array of RowGateway, containing every single row in the database.
	 *	If $data is an integer, a RowGateway will be returned.
	 *	If $data is a Conditions object, rows based on the object will be returned.
	 *
	 *	@param	mixed	$data
	 *	@return	mixed
	 *	@throws	SQLException
	 */
	public function get($data = null) 
	{
		try {
			switch (gettype($data)) {
				case 'integer':
				case 'string':
					return $this->findById($data);
			}
			return $this->findAll();
		}
		catch (SQLException $e) {
			throw $e;
		}
	}

	/**
	 *	Removes a row from the database.
	 *
	 *	@param	int		$id
	 *	@return	int
	 *	@throws	ApplicationException
	 */
	public function remove($id) 
	{
		$row	= $this->gateway->findById($id);
		if (!isset($row)) {
			throw new ApplicationException("Removal was not successful on id: ".$id);
		}
		try {
			return $row->remove();
		} catch (SQLException $e) {
			$response	= new Response();
			$response->setStatusToError($e->getMessage());
			return $response;
		}
	}

	/**
	 *	Find a row based on the key and its value.
	 *
	 *	@param	string		$key
	 *	@param	string		$value
	 *	@return	RowGateway
	 */
	public function findByKey($key, $value) 
	{
		return $this->gateway->findByKey($key, $value);
	}

	/**
	 *	Merge two records together to easier handle data from different tables.
	 *	If a key exsist in both records, the first parameter's key will be used.
	 *
	 *	@param	Record	$firstRecord
	 *	@param	Record	$secondRecord
	 *	@return	Record
	 */
	public function mergeRecords(Record $firstRecord, Record $secondRecord) 
	{
		$arr	= array_merge((array)$firstRecord, (array)$secondRecord);
		$record	= new Record();
		foreach ($arr as $key => $value) {
			$record->$key = $value;
		}
		return $record;
	}

	/**
	 *
	 *	Creates a join query with the two models.
	 *
	 *	@param	Conditions	$conditions
	 *	@return	array
	 *
	 */
	public function join(Conditions $conditions) 
	{
		$gateway	= new TableGateway($this->tableName);
		$query		= $conditions->generateQuery();
		return $gateway->get($query);
	}

	/**
	 *	Load a model and appends the retrieved record to the main record.
	 *
	 *	@param	Record	$aRecord
	 *	@param	string	$tableName
	 *	@param	string	$appendKey
	 *	@param	string	$connectedIdKey
	 *	@return	void
	 *	@throws	SQLException
	 */
	public function appendTableToRecord(Record &$aRecord, $tableName, $appendKey, $connectedIdKey) 
	{
		$record		= null;
		$model		= null;
		$factory	= null;
		if (strstr($tableName, "Factory") && isset($aRecord->$connectedIdKey)) {
			$record = $tableName::Load($aRecord->$connectedIdKey);
			$model	= new Model("User");
		}
		else {
			$model	= new Model($tableName);
			if (isset($aRecord->$connectedIdKey)) {
				try {
					$row		= $model->get($aRecord->$connectedIdKey);
					$record		= $row->getRecord();
				}
				catch (SQLException $e) {
					throw $e;
				}
			}
		}
		$model->appendRecord($aRecord, $record, $appendKey);
	}

	/**
	 *	Adds a key to the main record with the parameter record as value.
	 *
	 *	@param	Record	$baseRecord
	 *	@param	Record	$aRecord
	 *	@param	string	$key
	 *	@return	Record
	 */
	public function appendRecord(Record &$baseRecord, Record $aRecord = null, $key) 
	{
		$baseRecord->$key	= $aRecord;
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Returns a all rows from the table gateway.
	 *
	 *	@return	array
	 */
	protected function findAll() 
	{
		return $this->gateway->get();
	}

	/**
	 *	Returns a single row from the table gateway.
	 *
	 *	@param	int		$id
	 *	@return	RowGateway
	 */
	protected function findById($id) 
	{
		return $this->gateway->findById($id);
	}

	/**
	 *	Returns a number of rows from the table gateway based on the conditions.
	 *
	 *	@param	Conditions	$conditions
	 *	@return	array
	 */
	protected function findByConditions(Conditions $conditions) 
	{
		return $this->gateway->findById($id);
	}
}