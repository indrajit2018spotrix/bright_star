<?php

	namespace config\vortex;
	use app\Exceptions\Handler;
	use config\vortex\view;
	use helper\vortex_log_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class Controller{

		private $compact, $controller, $function;

		private $Controller_Classes = [
			"app\http\illuminate\controller\WelcomeController",
			"app\http\illuminate\controller\AppController",
			"app\http\illuminate\controller\SessionController",
			"app\http\illuminate\controller\UploadController"
		];

		public function __construct($controller, $function, $vars){
			$this->compact = $vars[0];
			$this->controller = $controller;
			$this->function = $function;
		}

		public function TriggerController(){

			$function_name = $this->function;

			$used_class_index = NULL;

			for($i=0; $i<sizeof($this->Controller_Classes); $i++){
				$used_class = $this->Controller_Classes[$i];
				$used_class_segment = explode('\\', $used_class);
				
				if(end($used_class_segment) == $this->controller){
					$used_class_index = $i;
					break;
				}
			}

			if(!isset($used_class_index)){
				$handler['message'] = $this->controller . " is not declared in Controller.";
				$log_message = $handler['message'];
				vortex_log_library::generate_log_record($log_message);
				$view_OBJ = new view();
				return $view_OBJ->render_view("app/500", $handler);
			}
			else{
				if(class_exists($this->Controller_Classes[$used_class_index])){
					$obj_name = $this->controller . "_OBJ";
					$thisClass = $this->Controller_Classes[$used_class_index];
					$$obj_name = new $thisClass($this->compact);
					if(method_exists($$obj_name, $function_name)){
						$report = $$obj_name->$function_name();
						$handler = Handler::clause_tunnel();
						$file_exists = 1;

						/*if(isset($handler['error'])){
							$view_OBJ = new view();
							return $view_OBJ->render_view("app/500", $handler);
						}
						else{
							return $report;
						}*/

						if(!isset($handler['error'])){
							return $report;
						}
						
					}
					else{
						$handler['message'] = $function_name . "() method doesn't exist in Class " . $this->controller;
						$log_message = $handler['message'];
						vortex_log_library::generate_log_record($log_message);
						$view_OBJ = new view();
						return $view_OBJ->render_view("app/500", $handler);
					}
				}
				else{
					$handler['message'] = "Class " . $this->controller . " is not defined.";
					$log_message = $handler['message'];
					vortex_log_library::generate_log_record($log_message);
					$view_OBJ = new view();
					return $view_OBJ->render_view("app/500", $handler);
				}
			}

		}

	}

?>