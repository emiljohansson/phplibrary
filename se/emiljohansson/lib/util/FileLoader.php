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
 *	Iterates files for the client-side.
 *
 *	Finds all client-side file, like css and js, and returns a list
 *	of string (the path to each file).
 *
 *	It is possible to priority and ignore certain files or folders.
 *	The priority files will be loaded first, so it is possible to use 
 *	only some files from a folder.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class FileLoader
{
	//-----------------------------------------------------------
	//	Public constant properties
	//-----------------------------------------------------------

	/**
	 *	List reference for the priority array.
	 *	@var integer
	 */
	const PRIORITY = "priority";

	/**
	 *	List reference for the library array.
	 *	@var integer
	 */
	const LIBRARY = "library";

	/**
	 *	List reference for the remaining array.
	 *	@var integer
	 */
	const REMAINING = "remaining";

	//-----------------------------------------------------------
	//	Public properties
	//-----------------------------------------------------------

	/**
	 *	The priority list.
	 *	@var array
	 */
	private $priority = array();

	/**
	 *	These files will not be added to the list.
	 *	@var array
	 */
	private $ignore;

	/**
	 *	These files will be added to the library.
	 *	@var array
	 */
	private $library;

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Adds an url, which will ignore that file of everything matching the url.
	 *
	 *	@param	string	$pathOrFile
	 *	@return	void
	 */
	public function addIgnore($pathOrFile) 
	{
		if (!isset($this->ignore)) $this->ignore = array();
		array_push($this->ignore, $pathOrFile);
	}

	/**
	 *	Adds an url, which will be added after the priority list.
	 *
	 *	@param	string	$pathOrFile
	 *	@return	void
	 */
	public function addLibrary($pathOrFile) 
	{
		if (!isset($this->library)) $this->library = array();
		array_push($this->library, $pathOrFile);
	}

	/**
	 *	Adds an url, which will be prioritised. This will be added before 
	 *	the ignore files, meaning its possible to ignore all files
	 *	in a folder except some.
	 *
	 *	@param	string	$pathOrFile
	 *	@return	void
	 */
	public function addPriority($pathOrFile) 
	{
		array_push($this->priority, $pathOrFile);
	}

	/**
	 *	Loads all javascript files and returns each script tag in one string.
	 *
	 *	@param	string	$basePath
	 *	@param	string	$extension
	 *	@param	array	$prio
	 *	@return	string
	 */
	public function loadClientFiles($basePath, $extension)
	{
		$list = array(
			self::PRIORITY	=> array(), 
			self::LIBRARY	=> array(), 
			self::REMAINING	=> array()
		);
		$iteratorPaths	= new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath), RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($iteratorPaths as $path) {
			if ($this->matchFileExtension($path, $extension)) {
				$path = str_replace("\\", "/", $path); //on windows
				$path = str_replace($basePath, "", $path);
				$this->addToList($list, $path);
			}
		}
		return $this->mergeLists($list);
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Returns the file extension of selected file.
	 *
	 *	@param	string	$fileName
	 *	@return	boolean
	 */
	private function matchFileExtension($fileName, $extension) 
	{
		return $this->getFileExtension($fileName) === $extension;
	}

	/**
	 *	Returns the file extension of selected file.
	 *
	 *	@param	string	$fileName
	 *	@return	string
	 */
	private function getFileExtension($fileName) 
	{
		return substr(strrchr($fileName,'.'),1);
	}

	/**
	 *	Adds the path to the correct part of the list.
	 *
	 *	@param	string	$fileName
	 *	@return	string
	 */
	private function addToList(array &$list, $path) 
	{
		if ($this->inList($path, $this->priority)) {
			array_push($list[self::PRIORITY], $path);
		}
		else if ($this->inList($path, $this->ignore)) {
			return;
		}
		else if ($this->inList($path, $this->library)) {
			array_push($list[self::LIBRARY], $path);
		}
		else {
			array_push($list[self::REMAINING], $path);
		}
	}

	/**
	 *	Returns if the path matches any path in the ignore list.
	 *
	 *	@param	string	$path
	 *	@param	array	$list
	 *	@return	boolean
	 */
	private function inList($path, $list = null)  
	{
		if (!isset($list)) return false;
		foreach ($list as $str) {
			if (strstr($path, $str)) {
				return true;
			}
		}
		return false;
	}

	/**
	 *	Merges all lists to one.
	 *
	 *	@return	array
	 */
	private function mergeLists($list) 
	{
		return array_merge($list[self::PRIORITY], $list[self::LIBRARY], $list[self::REMAINING]);
	}
}