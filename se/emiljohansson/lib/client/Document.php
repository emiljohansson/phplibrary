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
 *	Base for the construction of a web-document.
 *
 *	The Document class handles and are responsible for everything related
 *	to the construction of a HTML, JSON or XML page. All elements created in a project 
 *	will eventually be stored in this object.
 *
 *	It is possible to add header information, such as meta, css and js content.
 *
 *	To create new elements see the DOM object. Don't refer this object, only the 
 *	Engine needs to communicate with the Document object.
 *
 *	@version	0.1.1
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 *	@todo		Support json
 */
final class Document
{
	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	A singleton Document object.
	 *	@var Document
	 */
	private static $instance;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Returns an instance of the Document.
	 *
	 *	@return	Document
	 */
	public static final function get() 
	{
		if (!isset(self::$instance)) self::$instance = new Document();
		return self::$instance;
	}

	//-----------------------------------------------------------
	//	Public properties
	//-----------------------------------------------------------

	/**
	 *	The language attribute for the html tag; <html lang="en">. 
	 *	@var string
	 */
	public $lang = 'en';

	/**
	 *	The inner html for the title tag; <title>Default title</title>
	 *	@var string
	 */
	public $title = 'Default title';

	//-----------------------------------------------------------
	//	Private properties
	//-----------------------------------------------------------

	/**
	 *	An instance to the native DOMDocument class.
	 *	@var DOMDocument
	 */
	private $document;
	
	/**
	 *	The head tag; <head></head>. Meta, css and js files will
	 *	be appendend to this property.
	 *	@var DOMElement
	 */
	private $head;
	
	/**
	 *	The body tag; <body></body>. All display elements for the 
	 *	application will be placed here.
	 *	@var DOMElement
	 */
	private $body;

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes the document and creates the head and body tags.
	 *	
	 *	@return void
	 */
	private final function __construct() 
	{
		$this->document	= new DOMDocument();
		$this->head		= $this->document->createElement('head');
		$this->body		= $this->document->createElement('body');
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Adds a meta tag to the head node.
	 *
	 *	@param	string	$name
	 *	@param	array	$arr
	 *	@return	void
	 */
	public final function addMetaTag(array $arr) 
	{
		$element = $this->document->createElement('meta');
		foreach ($arr as $key => $value) {
			$element->setAttribute($key, $value);
		}
		$this->head->appendChild($element);
	}

	/**
	 *	Adds a stylesheet tag to the head node.
	 *
	 *	@param	string	$name
	 *	@param	string	$url
	 *	@return	void
	 */
	public final function addStylesheet($url) 
	{
		$element = $this->document->createElement('link');
		$element->setAttribute('rel', 'stylesheet');
		$element->setAttribute('type', 'text/css');
		$element->setAttribute('href', $url);
		$this->head->appendChild($element);
	}

	/**
	 *	Adds a script tag to the head node.
	 *
	 *	@param	string	$name
	 *	@param	string	$url
	 *	@return	void
	 */
	public final function addScript($url) 
	{
		$element = $this->document->createElement('script');
		$element->setAttribute('type', 'text/javascript');
		$element->setAttribute('src', $url);
		$this->head->appendChild($element);
	}

	/**
	 *	Appends an element to the body element.
	 *
	 *	@param	Element	$element
	 *	@return	void
	 */
	public final function appendChild($element) 
	{
		$this->body->appendChild($element);
	}

	/**
	 *	Creates a new element.
	 *
	 *	@param	string	$nodeName
	 *	@param	string	$nodeValue
	 *	@return	Element
	 */
	public final function createElement($nodeName, $nodeValue = null) 
	{
		return new Element($nodeName, $nodeValue);
	}

	/**
	 *	Returns the reference to the body element.
	 *
	 *	@return	DOMElement
	 */
	public final function getBody() 
	{
		return $this->body;
	}

	/**
	 *	Creates the page.
	 *
	 *	@return	void
	 */
	public final function assemble($format = 'html')
	{
		$html = $this->createWrapperNode($format);
		DOM::appendChild($this->head, Document::get()->createElement('title', $this->title));
		DOM::appendChild($html, $this->head);
		DOM::appendChild($html, $this->body);
		DOM::appendChild($this->document, $html);
		RootPanel::get()->load();
		if ($format === 'xml') {
			return $this->document->saveXML();
		}
		if ($format === 'json') {
			/*$result = array();
			$parser = new JSONParser();
			$parser->domNodes($html, $result);
			console::log(json_encode($result));
			return;*/

			#not implemented yet...
		}
		$doctype	= '<!DOCTYPE html>';
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