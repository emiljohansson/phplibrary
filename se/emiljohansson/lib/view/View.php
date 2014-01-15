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
 *	The presentation view.
 *
 *	The View object handles simple and complex construction of display objects.
 *	The View is an extention of a Widget, making it easy to add child
 *	widgets or other views to the view, using the add method from the Panel class.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class View extends Composite
{
	//-----------------------------------------------------------
	//	Public static properties
	//-----------------------------------------------------------

	/**
	 *	The default location to where project is located.
	 *	@var string
	 */
	public static $projectLocation	= "/";

	//-----------------------------------------------------------
	//	Public properties
	//-----------------------------------------------------------

	/**
	 *	Usign a model to collecting and updating data.
	 *	@var Model
	 */
	public $model;

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns the view as a Widget object.
	 *
	 *	@return	Widget
	 */
	public function asWidget() 
	{
		return $this->widget;
	}

	/**
	 *	Sets a content type.
	 *
	 *	@param	string	$type
	 *	@return	void
	 */ 
	public function setContentType($type = "html") 
	{
		header('Content-type: application/'.$type);
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Returns the base url for the project.
	 *
	 *	@return	string
	 */
	protected function getBaseUrl() 
	{
		return self::$projectLocation;
	}
}