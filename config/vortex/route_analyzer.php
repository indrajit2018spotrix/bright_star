<?php

	namespace config\vortex;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class route_analyzer{

		private $route;

		public function __construct($url){

			$request_uri = explode($GLOBALS['_-_-_manifest_-_-_']['_-_-_BASE_PATH_-_-_'], $url);
			$this->route = end($request_uri);

		}

		public function route(){

			if($this->route != '/'){

				if($this->route[strlen($this->route)-1] != '/')
					$URI = explode('/', $this->route . '/');
				else
					$URI = explode('/', $this->route);

				$web_uri = '';

				if($URI[1] != ''){

					for($i=2; $i<sizeof($URI); $i++)
						$web_uri = $web_uri . '/' . $URI[$i];

					$web_string = $web_uri;

					if(isset($web_uri[strlen($web_uri)-3])){
						if($web_uri[strlen($web_uri)-3]=='/' && $web_uri[strlen($web_uri)-2]=='/'){
							$web_string = '';
							for($i=0; $i<strlen($web_uri)-2; $i++)
								$web_string = $web_string . "" . $web_uri[$i];
						}
					}
					
					return [
						"success"	=>	1,
						"failure"	=>	0,
						"URI"		=>	$URI,
						"web_uri"	=>	$web_string,
						"message"	=>	"Good URL."
					];

				}
				else{

					return [
						"success"	=>	0,
						"failure"	=>	1,
						"message"	=>	"Invalid routing."
					];

				}
				
			}
			else{
				header('location: g7kjgh4y389250d7i3dfg934k985k5d3');
			}
		}

	}

?>