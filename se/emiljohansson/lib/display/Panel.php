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
 * Base class for easy appending of widgets.
 *
 * Base for several panels, making it easy to appending widgets.
 *
 * @version	0.1.0
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
abstract class Panel extends Widget {

	//----------------------------------------------------------
	// Public methods
	//----------------------------------------------------------

	/**
	 * Adds a widget to the document body.
	 *
	 * @param	Widget	$widget
	 * @return	void
	 */
	public function add(Widget $widget) {
		$widget->parent = $this;
		array_push($this->childWidgets, $widget);
		return $widget;
	}
	
	/**
	 * Adds the panel widget to the container.
	 * 
	 * @param	Widget	$container
	 * @return	void
	 */
	public function go(Widget $container) {
		$container->add($this->asWidget());
	}

	/**
	 * Iterates the list of children, appends them to this
	 * class widget element and calls their load method.
	 *
	 * @return	void
	 */
	public function load() {
		foreach ($this->childWidgets as $widget) {
			if ($widget->getElement() == null) {
				Console::error($widget);
				return;
			}
			DOM::appendChild($this->getElement(), $widget->getElement());
			$widget->load();
		}
		parent::load();
	}
}