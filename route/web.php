<?php

	namespace route;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class web{

		private $routes = array();

		public function __construct(){

			$this->routes = [
				[
					"routeID"		=>	"g7kjgh4y389250d7i385d934k985k5d3",
					"method"		=>	"get",
					"route"			=>	"/user/{userID}/bookID/{bookID}",
					"response_type"	=>	"string",
					"controller"	=>	NULL,
					"view"			=>	'welcome',
					"string"		=>	NULL
				],
				[
					"routeID"		=>	"g7kjgh4y389250d7i3dfg934k985k5d3",
					"method"		=>	"get",
					"route"			=>	"/",
					"response_type"	=>	"string",
					"controller"	=>	'AppController@app',
					"view"			=>	NULL,
					"string"		=>	NULL
				],
				[
					"routeID"		=>	"hjyt5623h87bf64cd385d934k985k5d3",
					"method"		=>	"get",
					"route"			=>	"/",
					"response_type"	=>	"string",
					"controller"	=>	NULL,
					"view"			=>	'app/403',
					"string"		=>	NULL
				],
				[
					"routeID"		=>	"hj67fg4y389250d7i3dfg934k985k5d3",
					"method"		=>	"get",
					"route"			=>	"/welcome/{key}",
					"response_type"	=>	"string",
					"controller"	=>	"WelcomeController@welcome",
					"view"			=>	NULL,
					"string"		=>	NULL
				]
			];

		}

		public function route_list(){
			return $this->routes;
		}

	}

	
	// ROUTE::get('/abc', "abcController@hello");

	/*
		if route id exists
			if pattern matches
				generate variable-var array
	*/

?>