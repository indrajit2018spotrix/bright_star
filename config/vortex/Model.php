<?php

	namespace config\vortex;
	use helper\vortex_log_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class Model{

		public static $Montroller_Classes = [
			"app\http\illuminate\model\WelcomeModel",
			"app\http\illuminate\model\AppModel"
		];

		public static function TriggerModel($class_function, $method_parameters){

			$class_function_segment = explode('@', $class_function);
			$ModelClass = $class_function_segment[0];
			$ModelFunction = $class_function_segment[1];

			$used_class_index = NULL;

			for($i=0; $i<sizeof(Model::$Montroller_Classes); $i++){
				$used_class = Model::$Montroller_Classes[$i];
				$used_class_segment = explode('\\', $used_class);
				
				if(end($used_class_segment) == $ModelClass){
					$used_class_index = $i;
					break;
				}
			}

			if(!isset($used_class_index)){
				$handler['message'] = $ModelClass . " is not declared in Model.";
				$log_message = $handler['message'];
				vortex_log_library::generate_log_record($log_message);
				$view_OBJ = new view();
				return [
							"model_data"	=>	$view_OBJ->render_view("app/500", $handler),
							"model_success"	=>	0
				];
			}
			else{
				if(class_exists(Model::$Montroller_Classes[$used_class_index])){
					$obj_name = $ModelClass . "_OBJ";
					$thisClass = Model::$Montroller_Classes[$used_class_index];
					$$obj_name = new $thisClass();
					if(method_exists($$obj_name, $ModelFunction)){
						if(isset($method_parameters)){
							return [
										"model_data"	=>	$$obj_name->$ModelFunction($method_parameters),
										"model_success"	=>	1
							];
						}
						else{
							return [
										"model_data"	=>	$$obj_name->$ModelFunction(),
										"model_success"	=>	1
							];
						}
					}
					else{
						$handler['message'] = $ModelFunction . "() method doesn't exist in Class " . $ModelClass;
						$log_message = $handler['message'];
						vortex_log_library::generate_log_record($log_message);
						$view_OBJ = new view();
						return [
									"model_data"	=>	$view_OBJ->render_view("app/500", $handler),
									"model_success"	=>	0
						];
					}
				}
				else{
					$handler['message'] = "Class " . $ModelClass . " is not defined.";
					$log_message = $handler['message'];
					vortex_log_library::generate_log_record($log_message);
					$view_OBJ = new view();
					return [
									"model_data"	=>	$view_OBJ->render_view("app/500", $handler),
									"model_success"	=>	0
					];
				}
			}

		}

	}

?>