#Engine

{engine_name} is a library that can be used for advanced and simple web applications. It makes it easy to quickly create a new web page and collecting data from the database.

It is not necessary to use a database, the Engine can still create html documents. 

##Set up a new project 

A quick-start library for creating server applications. 

##Suggested structure

	/project
		/client
			/application
			/lib
			/config
		/server
			/application
			/lib
				/engine files are placed here.
		index.php

##Hello world

Create an index.php file containing the following two lines:

	require_once 'path/to/library/util/autoloader.php';
	new Main();

Autoloader overrides the __autoload method and handles the importing of classes. The rule is that the filename has to be the exact same as the classname. Create the class Main.

	class Main extends Engine {}

The Engine class is dependent on is a Config class that contains the following 4 public variables:

	class Config 
	{
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
	}

The standard controller is set to be "HomeController". If no controller class is created, an error will occur. If you want a different default controller, override the initDefaultController method in the Main class. Create the HomeController, extending the base Controller class:

	class HomeController extends Controller {}

The Controller class will initialize the model and a view. To define a specific model and view, override the initModel and initView methods:

	protected function initModel() 
	{
		$this->model = new Model("User");
	}

	//Creates the view and adds a div tag with our Hello world message.
	protected function initView() 
	{
		$this->view	= new View();
		$this->view->add(new Label("Hello world!"));
	}

##Sign in/out authentication

The library includes an authentication controller. 

The path to signing in is "/auth/login" and it requires two post variables: email and password.
To sign in, go to "auth/logout".

Both paths prints the result in json format. If the sign in was successful, the user will be presented.


###Optional settings

####Autoload client-side files

It is possible to tell the engine to automatically load css and js files on the client side. First create a json-file, config.json, tentatively stored under ./client/config/. Also create a config file for localhost, config.local.json. Usually you want to use a compiled version for when the project live.

	{
		"title": "Page title",
		"meta": [
			{
				"name": "author",
				"content": "Emil Johansson"
			},
			{
				"name": "keywords",
				"content": ""
			},
			{
				"name": "description",
				"content": ""
			},
			{
				"name": "viewport",
				"content": "width=device-width, initial-scale=1.0"
			}
		],
		"css": ["client/lib/css/", "client/application/css/"],
		"js": ["client/lib/js/", "client/application/js/"]
	}

####Change the default path for php classes

As default the autoloader method, autoloader.php, will look for files stored under /server. To change this, use the defaultRootPath method after you have required the autoloader file:

	require_once 'new/path/tofiles/util/autoloader.php';
	defaultRootPath("new/path/tofiles/");
	new Main();

####Logging SQL, exceptions and performances

The engine is capable of logging all sql made by the user, all exceptions that might occur and how the application is performing. Start by adding a "var" folder in the base folder with the following sub-folder:

	/project
		/var
			/exceptions
				/application
				/sql
			/performance
			/sql

If unit tests are used also add the same structure, but in a test folder, still stored in the var folder:

	/project
		/var
			/test
				/...

####Unit test

The engine currently have about 7 test cases, with almost 100 passed tests. To setup unit test capability start by adding a test folder in the project base folder:

	/project
		/test

The engine is depending and using the "SimpleTest PHP unit tester" [http://simpletest.org/]. To create a test simple create a class extending SimpleTest's Unit TestCase class:

	class TestDatabase extends Unit TestCase 
	{
		function testMyMethod() {}
	}

##MVC

The engine has implemented a MVC pattern. The Controller is defined by the URL parameter "controller". The controller will then create the Model and View for selected page.

###Model

The model is the only way to abstract data from the database. Using the public method get, you receive all rows in the selected table. 

	//Get all rows from the table User
	$model = new Model('User');
	$rows = $model->get();

By adding an integer to the get method, only one row will be retrieved.

	$row = $model->get(1); //The user with id = 1

$rows now contain an array of RowGateway. To get more view friendly data, use RowGateway's getRecord method.

	foreach ($rows as $row) {
		$record = $row->getRecord();
	}

###Controller

The Controller class handles what the page should be presenting. Based on the $_GET['controller'] property, the engine automatically creates the selected class. The controller creates the view and model.

###Service

A service is an extension of the Controller class and can be seen as a helper class. Used a lot by View's and an API controller.

If the GET parameter 'service' is set, a service matching that property name will be generated. And if the method parameter is set, the Controller class will then try to call that method inside of the service. This is effective for example creating an API. Consider the following url:

api/user/update/1

This will create an APIController, which will create a UserService and the method update will be called. The last parameter, "1", is the output parameter, referring to what user id we will be updating.

###View

The view abstracts the data from the model the controller created and creates the elements that will be presented to the user.

	//In a View using a User Model to present the full name of a person.
	$row = $this->model->get(1);
	$record = $row->getRecord();
	$firstname = $record->firstname;
	$lastname = $record->lastname;
	$widget = new Label($firstname." ".$lastname);
	$this->add($widget);


##DOMDocument, /client

Everything presented to the user is created by using the PHP DOMDocument. There is no use of the echo method, using echo will break the DOM structure.

##Debug

To debug an object, use the Console object:

Console::log($myObject);
Console::error($myObject);

##TODO

##Known bugs

##Author

**Emil Johansson**

+ http://github.com/emiljohansson
+ http://twitter.com/emiljohanssonse