<?php

/**
 * {LIBRARY_NAME}
 *
 * PHP Version 5.3
 *
 * Inspired by the GWT library <http://www.gwtproject.org/>
 *
 * @copyright	Emil Johansson 2013
 * @license		http://www.opensource.org/licenses/mit-license.php MIT
 * @link		https://github.com/emiljohansson
 */

//--------------------------------------------------------------
// Public class
//--------------------------------------------------------------

/**
 * summary...
 *
 * description...
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Link extends Anchor {

	//----------------------------------------------------------
	// Private properties
	//----------------------------------------------------------

	/**
	 * ...
	 * @var string
	 */
	public $href;

	//----------------------------------------------------------
	// Constructor method
	//----------------------------------------------------------

	/**
	 * ...
	 * 
	 * @param	string	$content
	 * @param	string	$href
	 * @param	string	$icon
	 * @return	void
	 */
	public function __construct($content, $href = null, Icon $icon) {
		parent::__construct();
		//$this->setElement(DOM::createDiv());
		$this->add($icon);
		$this->add(new InlineLabel($content));
		if (isset($href)) {
			$this->setAttribute("href", $href);
		}
		$this->addStyleName('btn-link');
	}
}