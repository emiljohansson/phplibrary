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
 *	Logs performance messages.
 *
 *	The class stores a memory comparison between when the start method 
 *	is call and when the end method is called. 
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class PerformanceLog
{
	//-----------------------------------------------------------
	//	Constant properties
	//-----------------------------------------------------------

	/**
	 *	The folder where the exceptions are stored.
	 *	@var string
	 */
	const FOLDER = 'performance/';

	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	The initial memory usage.
	 *	@var int
	 */
	private static $start;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Starts the test.
	 *
	 *	@return	void
	 */
	public static function start() 
	{
		self::$start = memory_get_usage(false);
	}

	/**
	 *	Ends the test.
	 *
	 *	@return	void
	 */
	public static function end() 
	{
		$final	= memory_get_usage(false);
		$diff 	= $final - self::$start;
		Log::add(self::FOLDER, "Init: ".self::$start.", Final: ".$final.", Diff: ".$diff.", Peak: ".memory_get_peak_usage());
	}
}