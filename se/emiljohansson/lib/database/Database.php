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
 *	The direct and only connection to the MySQL database.
 *
 *	An extension of mysqli. 
 *	To access the singleton instance use the public static method instance().
 *	<code>
 *	Database::instance()->query($sql);
 *	</code>
 *
 *	@version	0.1.0
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Database extends mysqli 
{
	//-----------------------------------------------------------
	//	Public static properties
	//-----------------------------------------------------------

	/**
	 *	The location of the database, i.e. localhost.
	 *	@var string
	 */
	public static $host;

	/**
	 *	Username for the database.
	 *	@var string
	 */
	public static $username;

	/**
	 *	Password for the user.
	 *	@var string
	 */
	public static $password;

	/**
	 *	The database name.
	 *	@var string
	 */
	public static $dbname;

	//-----------------------------------------------------------
	//	Private static properties
	//-----------------------------------------------------------

	/**
	 *	Singular object.
	 *	@var Database
	 */
	private static $instance;

	//-----------------------------------------------------------
	//	Public static methods
	//-----------------------------------------------------------

	/**
	 *	Returns the instance of the database object.
	 *	
	 *	@return	Database
	 */
	public static function instance() {

		if (!isset(self::$instance)) {
			self::$instance = new Database();
			self::$instance->query('SET CHARACTER SET utf8');
		}
		return self::$instance;

	}

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Passes the public static properties to the mysqli object.
	 *
	 *	@return	void
	 */
	public function __construct() 
	{
		parent::__construct(self::$host, self::$username, self::$password, self::$dbname);
		if ($this->connect_errno) {
			echo "Failed to connect to MySQL: (" . $this->connect_errno . ") " . $this->connect_error;
		}
	}

	//-----------------------------------------------------------
	//	Public methods
	//-----------------------------------------------------------

	/**
	 *	Calls parent rollback and then reverses the auto increment.
	 *
	 *	@return void
	 */
	public function rollback($flags = NULL, $name = NULL)
	{
		parent::rollback();
		$sql	= "SHOW tables";
		$result	= Database::instance()->query($sql);

		while ($row = $result->fetch_assoc()) {
			$tbl = $row['Tables_in_'.self::$dbname];
			$sql = "ALTER TABLE $tbl AUTO_INCREMENT = 1;";
			Database::instance()->query($sql);
		}
	}
}