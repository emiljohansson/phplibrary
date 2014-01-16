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
 *	Parses a json file.
 *
 *	Retrives the JSON file and decodes its content.
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 *	@todo		create json out of all nodes.
 */
class JSONParser
{
	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Retrives the JSON file and decodes its content.
	 *
	 *	@param	string	$fileLocation	
	 *	@return	array
	 *	@throws	InvalidArgumentException
	 */
	public function file($fileLocation) 
	{
		$fileHandler	= @fopen($fileLocation, 'r');
		$fileContent	= @fread($fileHandler, filesize($fileLocation));
		$result	= json_decode($fileContent, TRUE);
		if ($result == "") {
			throw new InvalidArgumentException("Error parsing config file", 1);
		}
		return $result;
	}

	/**
	 *	Iterates all nodes and returns it as a encoded json string.
	 *
	 *	WARNING: under construction...
	 *
	 *	@param	DOMNode	$node
	 *	@return	string
	 */
	public function domNodes(DOMNode $domNode, array &$result) 
	{
		$result[$domNode->tagName] = array();
		console::log($result);
		foreach ($domNode->childNodes as $node) {
			$temp = array();
			$temp[$node->nodeName] = $node->nodeValue;
			if($node->hasChildNodes()) {
				$this->domNodes($node, $temp);
			}
			array_push($result[$domNode->tagName], $temp);
		}
	}
}