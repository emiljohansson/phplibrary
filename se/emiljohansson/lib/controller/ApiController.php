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
//	Public class
//--------------------------------------------------------------

/**
 * ...
 *
 * @version	0.1.1
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class ApiController extends Controller {

	//----------------------------------------------------------
	//	Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		Database::instance()->autocommit(false);
		$this->initService();
		$this->initOutput();
		$this->initMethod();
	}

	//----------------------------------------------------------
	//	Public methods
	//----------------------------------------------------------
	
	/**
	 * Adds the view to the widget.
	 * 
	 * @param	Widget	$container
	 * @return	string
	 */
	public function go(Widget $container = null) {
		return $this->view->render();
	}

	//----------------------------------------------------------
	//	Protected methods
	//----------------------------------------------------------

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
	 * Makes sure the user has signed in.
	 * Binds the view.
	 * 
	 * @return	void
	 */
	protected function initService() {
		parent::initService();
		if (!isset($this->service)) return;
		$this->view = $this->service->view;
	}
}