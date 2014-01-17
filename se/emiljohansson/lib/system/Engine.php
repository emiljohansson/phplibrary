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
 *	The engine/base of an application.
 *
 *	The Engine object is the starting point of an application.
 *	It initializes the session, the MVC objects and the DOM.
 *
 *	@version	0.1.2
 *	@author		Emil Johansson <emiljohansson.se@gmail.com>
 */
class Engine
{
	//-----------------------------------------------------------
	//	Public properties
	//-----------------------------------------------------------

	/**
	 *	An instance of the Session object, which will contains 
	 *	an instance of this Engine object so it will be possible
	 *	to access the engine anywhere in the application code.
	 *	@var Session
	 */
	public $session;

	/**
	 *	An instance of a Controller object, created using the
	 *	URL controller parameter.
	 *	@var Controller
	 */
	public $controller;

	/**
	 *	Where the starting point of the project is stored.
	 *	@var string
	 */
	public $default_root_path = "./";

	//-----------------------------------------------------------
	//	Protected properties
	//-----------------------------------------------------------

	/**
	 *	Config object.
	 *	@var Config
	 */
	protected $config;

	/**
	 *	An object for including client side files like css and js.
	 *	@var FileLoader
	 */
	protected $fileLoader;

	/**
	 *	The version of the application not the engine library.
	 *	@var string
	 */
	protected $applicationVersion;

	//-----------------------------------------------------------
	//	Private properties
	//-----------------------------------------------------------

	/**
	 *	The format the page will be rendered in.
	 *	@var string
	 */
	private $format = 'html';

	//-----------------------------------------------------------
	//	Constructor method
	//-----------------------------------------------------------

	/**
	 *	Initializes the following parts:
	 *	<ul>
	 *		<li>session: Starts the current session.</li>
	 *		<li>database: The connection to the MySQL database.</li>
	 *		<li>project spcific: Any possible special properties the project might have.</li>
	 *		<li>controller: Handles what will be presented to the user.</li>
	 *		<li>document: Creates a DOM structure.</li>
	 *		<li>output: Renders the output of the Document object.</li>
	 *	</ul>
	 *	
	 *	@return void
	 */
	public function __construct() 
	{
		$this->initFormat();
		$this->initSession();
		$this->initDatabase();
		$this->initProjectSpecific();
		$this->initController();
		$this->initDocument();
		$this->initOutput();
	}

	//-----------------------------------------------------------
	//	Protected methods
	//-----------------------------------------------------------

	/**
	 *	Based on the format property, the content can be changed from
	 *	default html to xml or json.
	 *
	 *	@return	void
	 */
	protected function initFormat() 
	{
		if (!isset($_GET['format'])) return;
		$this->setContentType($_GET['format']);
		$this->format = $_GET['format'];
		Document::init($this->format);
	}

	/**
	 *	Initializes the engine to the current session.
	 *	
	 *	@return	void
	 */
	protected function initSession() 
	{
		Session::init($this);
	}

	/**
	 *	Initializes a connection to the MySQL database.
	 *	
	 *	@return	void
	 */
	protected function initDatabase() 
	{
		$this->config		= new Config();
		Database::$host		= $this->config->host;
		Database::$username	= $this->config->username;
		Database::$password	= $this->config->password;
		Database::$dbname	= $this->config->dbname;
	}

	/**
	 *	Initializes any possible special properties the project might have.
	 *	By default the project location is found and stored in the View class.
	 *	
	 *	@return	void
	 */
	protected function initProjectSpecific() 
	{
		View::$projectLocation = str_replace("index.php", "", $_SERVER['PHP_SELF']);
	}

	/**
	 *	Initializes the selected controller, based on the URL controller parameter.
	 *	
	 *	@return	void
	 */
	protected function initController()
	{
		if (!isset($_GET['controller'])) {
			$this->initDefaultController();
			return;
		}
		$controllerClass = $_GET['controller']."Controller";
		if (!class_exists($controllerClass)) {
			Console::error(@$_GET['controller']." doesn't exist");
			$this->initDefaultController();
			return;
		}
		$this->controller = new $controllerClass();
	}

	/**
	 *	Initializes the default controller when the url doesn't specifies it.
	 *	Either override this method or create a HomeController class for the project.
	 *	
	 *	@return	void
	 */
	protected function initDefaultController()
	{
		if (!class_exists("HomeController")) return;
		$this->controller = new HomeController();
	}

	/**
	 *	Initializes content for the head node for the html document.
	 *	If a json config file is specified, all meta, css and js files
	 *	will be automatically generated.
	 *
	 *	@return	void
	 */
	protected function initDocument() 
	{
		if ($this->format !== 'html') return;
		$this->initFileLoader();
		$config	= $this->generateConfigData();
		$doc	= Document::get();
		if (!isset($config)) {
			return;
		}
		foreach ($config['meta'] as $arr) {
			$doc->addMetaTag($arr);
		}
		foreach ($config['css'] as $path) {
			$this->appendFile($doc, $path, "css");
		}
		foreach ($config['js'] as $path) {
			$this->appendFile($doc, $path, "js");
		}
	}

	/**
	 *	Initializes the file loader object. Override this method
	 *	if special files need to be read in a certain order.
	 *
	 *	@return	void
	 */
	protected function initFileLoader() 
	{
		$this->fileLoader = new FileLoader();
	}

	/**
	 *	Parses the data from the config.json file.
	 *	
	 *	@param	string | null	$jsonFile
	 *	@return	JSONParser
	 *	@throws	ApplicationException
	 */
	protected function generateConfigData($jsonFile = null)
	{
		if (!isset($this->config->opt_jsonConfigFile)) return;
		$ext = ".json";
		if(Host::get()->isLocalhost()){
			$ext = ".local".$ext;
		}
		$jsonFile = isset($jsonFile) ? $jsonFile : $this->config->opt_jsonConfigFile.$ext;
		try {
			$parser = new JSONParser();
			return $parser->file($jsonFile);
		}
		catch (InvalidArgumentException $e) {
			Console::error($e->getMessage());
			throw new ApplicationException("Error Processing Request");
		}
	}

	/**
	 *	Renders the page.
	 *
	 *	@return	void
	 *	@todo	Come up with a more generic solution.
	 */
	protected function initOutput() 
	{
		if (!isset($this->controller)) {
			Console::error("Error: no controller was created.");
			return;
		}
		if (get_class($this->controller) === "ApiController" ||
			is_subclass_of($this->controller, "ApiController")) {
			$this->renderOutputWithController();
			return;
		}
		$this->renderWithDocument();
	}

	//-----------------------------------------------------------
	//	Private methods
	//-----------------------------------------------------------

	/**
	 *	Appends files from a base url.
	 *
	 *	@param	Document	$doc
	 *	@param	string		$path
	 *	@param	string		$extension
	 *	@return	void
	 */
	private function appendFile(Document $doc, $path, $extension) 
	{
		foreach ($this->fileLoader->loadClientFiles($path, $extension) as $key => $url) {
			if (isset($this->applicationVersion)) {
				$url .= '?v'.$this->applicationVersion;
			}
			$file = (View::$projectLocation.$path).$url;
			switch ($extension) {
				case 'js':
					$doc->addScript($file);
					break;
				case 'css':
					$doc->addStyleSheet($file);
					break;
			}
		}
	}

	/**
	 *	Sets a content type.
	 *
	 *	@param	string	$type
	 *	@return	void
	 */ 
	private function setContentType($type = "html") 
	{
		header('Content-type: application/'.$type);
	}

	/**
	 *	Initializes the page and its elements as html content.
	 *
	 *	@return	void
	 */
	private function renderWithDocument() 
	{
		$this->controller->go(RootPanel::get());
		$output	= Document::get()->assemble();
		printf('%s', $output);
	}

	/**
	 *	Initializes the page and its elements as json content.
	 *
	 *	@return	void
	 */
	private function renderOutputWithController() 
	{
		printf('%s', $this->controller->go());
	}
}