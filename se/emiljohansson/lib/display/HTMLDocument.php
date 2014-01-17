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
 *	Assemples the document in html format.
 *
 *	@version	0.1.4
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class HTMLDocument extends Document
{
	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------
	
	/**
	 *	{@inheritdoc}
	 */
	public function assemble()
	{
		$html = $this->createWrapperNode();
		DOM::appendChild($this->head, Document::get()->createElement('title', $this->title));
		DOM::appendChild($html, $this->head);
		DOM::appendChild($html, $this->body);
		DOM::appendChild($this->document, $html);
		RootPanel::get()->load();
		$doctype = '<!DOCTYPE html>';
		return $doctype.$this->document->saveHTML();
	}

	//-----------------------------------------------------------
	//	Private methods
	//-----------------------------------------------------------

	/**
	 *	Initializes and returns the html node.
	 *
	 *	@return	DOMElement
	 */
	private final function createWrapperNode($format = null) 
	{
		$html = $this->document->createElement('html');
		if ($format === null) {
			$html->setAttribute('xmlns', 'http://www.w3.org/1999/xhtml');
			$html->setAttribute('lang', $this->lang);
		}
		return $html;
	}
}