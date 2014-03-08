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

//---------------------------------------------------------------
// Public class
//---------------------------------------------------------------

/**
 * Managing the signing in and out.
 *
 * @version	0.1.1
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class AuthController extends ApiController {

	//-----------------------------------------------------------
	// Public methods
	//-----------------------------------------------------------

	/**
	 * ...
	 *
	 * @return void
	 */
	public function initModel() {
		$this->model = new AuthModel();
	}

	/**
	 * Makes an attempt to match the passed username and password.
	 *
	 * @return void
	 */
	public function login() {
		$record	= $this->model->attempt(@$_POST['username'], @$_POST['password']);

		if (isset($record)) {
			unset($record->password);
			Auth::setUser($record);
			$this->view->addObject((array)Auth::getUser());
			return;
		}

		$this->view->setStatusToError("Invalid username or password");
	}

	/**
	 * ...
	 *
	 * @return void
	 */
	public function logout() {
		Session::$engine->session->destroy();
	}

	//-----------------------------------------------------------
	// Protected methods
	//-----------------------------------------------------------

	/**
	 * ...
	 *
	 * @return	void
	 */
	protected function initView() {
		$this->view 				= new ApiView();
		$this->view->model	= $this->model;
	}

	/**
	 * Uses the service and tries to call a method in this controller.
	 * 
	 * @return	void
	 */
	protected function initService() {
		if (!isset($_GET['service'])) return;
		$method	= $_GET['service'];
		if (!method_exists($this, $method)) return;
		$this->$method();
	}

	//-----------------------------------------------------------
	// Private methods
	//-----------------------------------------------------------

	/**
	 * Makes an attempt to find a match.
	 *
	 * @param	string	username
	 * @param	string	password
	 * @param	Record || null
	 */
	private function attempt($username, $password) {
		$user			= new Record();
		$user->username	= $username;
		$user->password	= $password;
		$row = $this->gateway->match($user);
		if (!isset($row)) return null;
		return $row->getRecord();
	}
}