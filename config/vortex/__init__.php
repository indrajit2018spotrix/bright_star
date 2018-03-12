<?php

	namespace config\vortex;
	use config\vortex\route_analyzer;
	use config\vortex\ROUTE;
	use config\vortex\view;
	use route\web;
	use app\Exceptions\Handler;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class __init__{

		public static function init_routing($SERVER_VARS){
			$route_OBJ = new route_analyzer($SERVER_VARS['REQUEST_URI']);
			$route_analyzer_response = $route_OBJ->route();
			if($route_analyzer_response['success']==1 && $route_analyzer_response['failure']==0){
				$web_OBJ = new web();

				$ROUTE_obj = new ROUTE($web_OBJ->route_list());
				return $ROUTE_obj->__init_routing__($route_analyzer_response['web_uri'], $route_analyzer_response['URI'][1], $SERVER_VARS['REQUEST_METHOD']);

			}
			else{
				$view_OBJ = new view();
				return $view_OBJ->render_view("app/400", $route_analyzer_response['message']);
			}
		}

	}

?>