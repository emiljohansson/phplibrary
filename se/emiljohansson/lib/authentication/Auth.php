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

//---------------------------------------------------------------
// Public class
//---------------------------------------------------------------

/**
 * An easy access of the sessions signed in user.
 *
 * @version	0.1.1
 * @author	Emil Johansson <emiljohansson.se@gmail.com>
 */
class Auth {

	//-----------------------------------------------------------
	// Public constant properties
	//-----------------------------------------------------------

	/**
	 * The string connected to the active user.
	 * @var string
	 */
	const SESSION_USER = 'APP_SIGNED_IN_USER';

	//-----------------------------------------------------------
	// Public static methods
	//-----------------------------------------------------------

	/**
	 * Returns the active user.
	 *
	 * @return	Record
	 */
	public static final function getUser() {
		return Session::$engine->session->get(Auth::SESSION_USER);
	}

	/**
	 * Sets the active user.
	 *
	 * @param	Record	$user
	 */
	public static final function setUser(Record $user) {
		Session::$engine->session->set(Auth::SESSION_USER, $user);
	}

	/**
	 * Returns if a user is sign in.
	 *
	 * @return	boolean
	 */
	public static final function userIsSignedIn() {
		$user = Session::$engine->session->get(Auth::SESSION_USER);
		return isset($user);
	}
}