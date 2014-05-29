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
 * Creates an icon.
 *
 * The names for the factory methods is currently based on the 
 * FontAwesome project <http://fortawesome.github.io/Font-Awesome/>. 
 *
 * @version	0.1.4
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Icon extends Widget {

	//----------------------------------------------------------
	// Private properties
	//----------------------------------------------------------

	/**
	 * The chosen css class.
	 * @var string
	 */
	private $cssClass;
	
	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * Initializes an i tag and saves the passed css class.
	 * 
	 * @return void
	 */
	public function __construct($cssClass = "") {
		parent::__construct();
		$this->setElement(Document::get()->createElement('i'));
		$this->cssClass = $cssClass;
	}

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Sets the selected css class to the element.
	 *
	 * @return	void
	 */
	public function load() {
		$this->getElement()->setAttribute("class", $this->cssClass);
	}
}