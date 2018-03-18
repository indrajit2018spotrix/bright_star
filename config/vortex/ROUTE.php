<?php

	namespace config\vortex;
	use config\vortex\Controller;
	use config\vortex\view;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class ROUTE{

		private $url_var_arr = array();
		private $route, $routeIndex;
		private $ROUTES = array();

		public function __construct($ROUTES){
			$this->ROUTES = $ROUTES;
		}

		private function generate_route_url($url, $routeID, $Request_Method){

			// $index = FALSE;
			$count = 0;
			$route_ID_found = 0;
			$request_method_found = 0;

			foreach($this->ROUTES as $routes){
				if($routes["routeID"] == $routeID){
					$route_ID_found = 1;
					if(strcasecmp($Request_Method, $routes["method"]) == 0){
						$index = $count;
						$this->routeIndex = $index;
						$request_method_found = 1;
						break;
					}
				}
				$count++;
			}

			if($route_ID_found==0 && $request_method_found==0){
				return [
					"success"	=>	0,
					"failure"	=>	1,
					"http_code"	=>	400,
					"message"	=>	"No such route declared."
				];
			}
			elseif($route_ID_found==1 && $request_method_found==0){
				return [
					"success"	=>	0,
					"failure"	=>	1,
					"http_code"	=>	405,
					"message"	=>	"Wrong method calling."
				];
			}
			else{

				$this->route = $this->ROUTES[$index]["route"];

				if(substr($this->route, strlen($this->route)-1, 1) != '/')
					$this->route = $this->route . '/';

				$this_route_array = explode('/', $this->route);
				$url_array = explode('/', $url);

				if(sizeof($this_route_array) != sizeof($url_array)){
					return [
						"success"	=>	0,
						"failure"	=>	1,
						"http_code"	=>	400,
						"message"	=>	"No such route declared."
					];
				}
				else{

					if(substr($url_array[1], 0, 1) == '{'){
						return [
							"success"	=>	0,
							"failure"	=>	1,
							"http_code"	=>	400,
							"message"	=>	"Invalid Route."
						];
					}
					else{

						$error = 0;
						$data = array();

						for($i=0; $i<sizeof($this_route_array); $i++){

							if(substr($this_route_array[$i], 0, 1) == '{'){

								$var = '';
								for($j=1; $j<strlen($this_route_array[$i])-1; $j++)
									$var = $var . '' . substr($this_route_array[$i], $j, 1);

								$value = '';
								for($j=0; $j<strlen($url_array[$i]); $j++)
									$value = $value . '' . substr($url_array[$i], $j, 1);

								$data[$var] = $value;

							}
							else{

								if($this_route_array[$i] != $url_array[$i]){

									$error = 1;

									return [
										"success"	=>	0,
										"failure"	=>	1,
										"http_code"	=>	400,
										"message"	=>	"No such route declared."
									];

									break;

								}

							}

						}

						if($error == 0){

							array_push($this->url_var_arr, $data);

							return [
								"success"		=>	1,
								"failure"		=>	0,
								"message"		=>	"Route found.",
								"route_data"	=>	$this->url_var_arr
							];

						}

					}

				}

			}

		}

		public function __init_routing__($url, $routeID, $Request_Method){

			$route_response = $this->generate_route_url($url, $routeID, $Request_Method);

			if($route_response['success']==1 && $route_response['failure']==0){

				if(isset($this->ROUTES[$this->routeIndex]['controller'])){

					$controller_array = explode('@', $this->ROUTES[$this->routeIndex]['controller']);
					$controller = $controller_array[0];
					$function = $controller_array[1];

					$controller_OBJ = new Controller($controller, $function, $this->url_var_arr);
					$response = $controller_OBJ->TriggerController();
					if(!$GLOBALS['_-_-_viewported_-_-_']){
						echo "<pre>";
						print_r($response);
					}
					
				}
				elseif(isset($this->ROUTES[$this->routeIndex]['view'])){
					$view_OBJ = new view();
					print_r($view_OBJ->render_view($this->ROUTES[$this->routeIndex]['view'], $this->url_var_arr));
				}
				elseif(isset($this->ROUTES[$this->routeIndex]['string'])){
					print_r($this->ROUTES[$this->routeIndex]['string']);
				}

			}
			else{
				$view_OBJ = new view();
				if(isset($route_response['http_code'])){
					return $view_OBJ->render_view("app/" . $route_response['http_code'], $route_response);
				}
				else{
					return $view_OBJ->render_view("app/404", $route_response);
				}
			}
		}

	}

?>