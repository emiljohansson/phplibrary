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

/**
 *	Returns (and updates) the path to where the php classses are stored.
 *	By default the path is set to "./server".
 *
 *	@param	string	$newPath
 *	@return string
 */	
function defaultRootPath($newPath = null, $push = false) 
{
	static $paths = array("./server");
	if ($push) {
		array_push($paths, $newPath);
	}
	else {
		if (isset($newPath)) {
			$paths[0] = $newPath;
		}
	}
	return $paths;
}

/**
 *	Appends a new path to iterate.
 *
 *	@param	string	$path
 *	@return	void
 */
function addDefaultRootPath($path)
{
	defaultRootPath($path, true);
}

/**
 *	Finds and loads a class. The rule is that the file name and the class
 *	name has to be matching for the autoload to work.
 *
 *	@param	string	$className
 *	@return	void
 */
function __autoload($className) 
{
	static $lineBreak;
	static $iteratorPaths;
	static $iteratorClassName;
	if (!isset($iteratorPaths)) {
		if  (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $lineBreak = '\\';
		else $lineBreak = '/';
		$rootPaths = defaultRootPath();
		if (isset($_GET['controller'])) {
			if ($_GET['controller'] == "unittest") {
				$rootPaths = './';
			}
		}
		$iteratorPaths		= array();
		$iteratorClassName	= array();
		foreach ($rootPaths as $rootPath) {
			$rii		= new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($rii as $path) {
				if (get_file_extension($path) === "php") {
					array_push($iteratorPaths, $path);
					array_push($iteratorClassName, strtolower(substr( strrchr( $path, $lineBreak ), 1 )));
				}
			}
		}
	}

	$classFile	= strtolower($className).".php";
	$indexof	= array_search($classFile, $iteratorClassName);
	if ($indexof !== FALSE) {
		$path = $iteratorPaths[$indexof];
		if (strtolower(substr( strrchr( $path, $lineBreak ), 1 )) === $classFile) {
			array_splice($iteratorPaths, $indexof, 1);
			array_splice($iteratorClassName, $indexof, 1);
			require_once $path;
			return;
		}
	}

	// should not go this far, old solution...
	for ($i = 0, $size = count($iteratorPaths); $i < $size; $i++) { 
		$path = $iteratorPaths[$i];
		if (strtolower(substr(strrchr($path, $lineBreak), 1)) === $classFile) {
			array_splice($iteratorPaths, $i, 1);
			array_splice($iteratorClassName, $i, 1);
			require_once $path;
			break;
		}
	}
}

/**
 *	Returns the file extension of selected file.
 *
 *	@param	string	$file_name
 *	@return	string
 */
function get_file_extension($file_name) 
{
	return substr(strrchr($file_name,'.'),1);
}