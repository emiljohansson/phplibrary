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
 *	A helper object for managing models. Mostly used by the api controller.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Service extends Controller 
{
	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Overrides the default View to initialize an instance of a APIView.
	 *	
	 *	@return	void
	 */
	protected function initView() 
	{
		$this->view	= new ApiView();
	}

	/**
	 *	Checks if the response is successful. If not, the process will stop
	 *	and a rollback will be triggered.
	 *	Else and if no more processes need to be made, a commit will be triggered.
	 *
	 *	@param	Response	$response, 
	 *	@param	boolean		$isDone
	 *	@return	boolean
	 */
	protected function checkResponse(Response $response, $isDone = false) 
	{
		if (!$response->wasSuccessful()) {
			if (!Log::$isUnitTesting) 
				Database::instance()->rollback();
			return false;
		}
		if (!$isDone || Log::$isUnitTesting) return true;
		return $this->commit();
	}

	/**
	 *	A helper method to save a record or an array of records.
	 *
	 *	@param	Model			$model
	 *	@param	Record|array	$record
	 *	@return	boolean
	 */
	protected function save(Model $model, $record) 
	{
		if (gettype($record) == "array") {
			return $this->saveAsArray($model, $record);
		}
		else if (gettype($record) == "object") {
			return $this->saveAsRecord($model, $record);
		}
		return false;
	}

	/**
	 *	A helper method that removes the selected id from the database table.
	 *
	 *	@param	Model			$model
	 *	@param	Record|array	$record
	 *	@return	void
	 */
	protected function remove(Model $model, $record) 
	{
		if (gettype($record) == "array") {
			return $this->removeAsArray($model, $record);
		}
		else if (gettype($record) == "object") {
			return $this->removeAsRecord($model, $record);
		}
		return false;
	}

	/**
	 *	Commits the updates to the database.
	 *
	 *	@return	boolean
	 *	@todo	Refactor from the service. 
	 *			Database should not be in this level.
	 */
	protected function commit() 
	{
		if (!Log::$isUnitTesting) {
			return Database::instance()->commit();
		}
		return true;
	}

	//-----------------------------------------------------------
	//	Private methods
	//-----------------------------------------------------------

	/**
	 *	Saves the records.
	 *
	 *	@param	Model	$model
	 *	@param	mixed	$recordList
	 *	@return	void
	 */
	private function saveAsArray(Model $model, array $recordList) 
	{
		foreach ($recordList as $record) {
			$response	= $model->save($record);
			$data		= $response->toArray();
			$this->view->addObject($data['body'], true);
			if (!$response->wasSuccessful()) {
				$this->view->setResponse($response);
				Database::instance()->rollback();
				return false;
			}
		}
		return $this->commit();
	}

	/**
	 *	Saves the record.
	 *
	 *	@param	Model	$model
	 *	@param	Record	$record
	 *	@return	void
	 */
	private function saveAsRecord(Model $model, Record $record) 
	{
		$response	= $model->save($record);
		$arr		= $response->toArray();
		$this->view->addObject($arr['body']);
		if (!$response->wasSuccessful()) {
			$this->view->setResponse($response);
			Database::instance()->rollback();
			return false;
		}
		return $this->commit();
	}

	/**
	 *	Removes each record in the list.
	 *
	 *	@param	Model	$model
	 *	@param	mixed	$recordList
	 *	@return	void
	 */
	private function removeAsArray(Model $model, array $recordList) 
	{
		foreach ($recordList as $record) {
			if (!$this->removeAsRecord($model, $record, false)) return false;
		}
		return $this->commit();
	}

	/**
	 *	Removes the record.
	 *
	 *	@param	Model	$model
	 *	@param	Record	$record
	 *	@return	boolean
	 */
	private function removeAsRecord(Model $model, Record $record, $doCommit = true) 
	{
		$response = new Response();
		try {
			$model->remove($record->id);
		}
		catch (ApplicationException $e) {
			$response->setStatusToError($e->getMessage());
		}
		$this->view->setResponse($response);
		if (!$response->wasSuccessful()) {
			Database::instance()->rollback();
			return false;
		}
		$response->add((array)$record);
		if ($doCommit) return $this->commit();
		return true;
	}
}