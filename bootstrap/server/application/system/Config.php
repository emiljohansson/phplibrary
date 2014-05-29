<?php

class Config {
	/**
	 *	The domain host, e.g. localhost.
	 *	@var string
	 */
	public $host;

	/**
	 *	The username to the database, e.g. root.
	 *	@var string
	 */
	public $username;

	/**
	 *	Password connected to the username.
	 *	@var string
	 */
	public $password;

	/**
	 *	The database to connect to.
	 *	@var string
	 */
	public $dbname;

	/**
	 *	The database to connect to.
	 *	@var string
	 */
	public $opt_jsonConfigFile = './client/config/config';
}