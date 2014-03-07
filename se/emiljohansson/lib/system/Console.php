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
 * A debugger class, inspired by the console object for web browsers.
 *
 * Helps the developer debug the code. The class prints out 
 * preformatted text.
 *
 * @version	0.1.0
 * @author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Console {

	//----------------------------------------------------------
	// Private static properties
	//----------------------------------------------------------

	/**
	 * Will group the logs while not null.
	 * @var array
	 */
	private static $group;

	//----------------------------------------------------------
	// Public static methods
	//----------------------------------------------------------

	/**
	 * Prints the object.
	 * 
	 * @param	mixed	obj
	 * @return	void
	 */
	public static function log($obj) {
		if (self::$group !== null) {
			$size	= count(self::$group);			
			array_push(self::$group[$size-1], $obj);
			return;
		}
		self::pre($obj, "black");
	}

	/**
	 * Prints the object as an error.
	 * 
	 * @param	mixed	obj
	 * @return	void
	 */
	public static function error($obj) {
		self::pre($obj, "red");
	}

	/**
	 * Prints the object as a warning.
	 * 
	 * @param	mixed	obj
	 * @return	void
	 */
	public static function warn($obj) {
		self::pre($obj, "yellow");
	}

	/**
	 * The console.assert() method conditionally displays an error string (its second parameter) 
	 * only if its first parameter evaluates to false.
	 * 
	 * @param	boolean	bool
	 * @param	string	message
	 * @return	void
	 */
	public static function assert($bool, $message) {
		if ($bool) return;
		self::error($message);
	}

	/**
	 * Starts grouping the logs, will be presented after calling groupEnd()
	 * 
	 * @param	string	message
	 * @return	void
	 */
	public static function group($message) {
		if (self::$group === null)
			self::$group = array();
		$size				= count(self::$group);
		self::$group[$size]	= array();
		array_push(self::$group[$size], $message);
	}

	/**
	 * Prints out each 
	 * 
	 * @return	void
	 */
	public static function endGroup() {
		return;
		if (self::$group === null) return;
		$tempGroup		= array_pop(self::$group);
		foreach ($tempGroup as $obj) {
			self::log($obj);
		}
	}

	//----------------------------------------------------------
	// Private static methods
	//----------------------------------------------------------

	/**
	 * Prints the object.
	 * 
	 * @param	mixed	content
	 * @return	void
	 */
	private static function pre($obj, $color) {
		$arr	= debug_backtrace();
		$caller	= $arr[2];
		echo "<div><span>[".$caller['class']."]: </span>";
		echo '<pre style="font: \'Monaco\' 12px; color:'.$color.'">';
		print_r($obj);
		echo '</pre>';
	}
}