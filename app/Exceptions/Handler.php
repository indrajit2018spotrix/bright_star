<?php

	namespace app\Exceptions;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class Handler{

		public static function clause_tunnel(){

			$error_details = array();
			$error_details['error'] = NULL;

			if(error_get_last()){

				$error = error_get_last();

				switch($error['type']){ 
			        case 1:
			            	$error_type = 'E_ERROR'; 
			        case 2:
			            	$error_type = 'E_WARNING'; 
			        case 4:
			            	$error_type = 'E_PARSE'; 
			        case 8:
			            	$error_type = 'E_NOTICE'; 
			        case 16:
			            	$error_type = 'E_CORE_ERROR'; 
			        case 32:
			            	$error_type = 'E_CORE_WARNING'; 
			        case 64:
			            	$error_type = 'E_COMPILE_ERROR'; 
			        case 128:
			            	$error_type = 'E_COMPILE_WARNING'; 
			        case 256:
			            	$error_type = 'E_USER_ERROR'; 
			        case 512:
			            	$error_type = 'E_USER_WARNING'; 
			        case 1024:
			            	$error_type = 'E_USER_NOTICE'; 
			        case 2048:
			            	$error_type = 'E_STRICT'; 
			        case 4096:
			            	$error_type = 'E_RECOVERABLE_ERROR'; 
			        case 8192:
			            	$error_type = 'E_DEPRECATED'; 
			        case 16384:
			            	$error_type = 'E_USER_DEPRECATED'; 
			    }

			    $error_details['error'] = '1';
			    $error_details['type'] = $error['type'];
        		$error_details['name'] = $error_type;
        		$error_details['code'] = 500;
        		$error_details['code_name'] = "Internal Server Error";
        		$error_details['file'] = $error['file'];
        		$error_details['line'] = $error['line'];
        		$error_details['message'] = $error['message'];
				
		    }
			
			return $error_details;

		}

	}

?>