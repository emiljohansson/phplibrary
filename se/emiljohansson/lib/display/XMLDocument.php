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
 *	Assemples the document in xml format.
 *
 *	@version	0.1.4
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class XMLDocument extends Document implements DocumentInterface
{
	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------
	
	/**
	 *	{@inheritdoc}
	 */
	public final function assemble()
	{
		$root = $this->document->createElement('root');
		DOM::appendChild($root, $this->head);
		DOM::appendChild($root, $this->body);
		DOM::appendChild($this->document, $root);
		RootPanel::get()->load();
		return $this->document->saveXML();
	}
}