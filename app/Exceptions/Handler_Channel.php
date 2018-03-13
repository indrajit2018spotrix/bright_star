<?php

	namespace app\Exceptions;
	use app\Exceptions\Handler;
	use helper\vortex_log_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class Handler_Channel{

		public static function channelize_view($file, $compact){

			if(file_exists($file)){
				$file_verified = 0;
				foreach($GLOBALS['_-_-_fileread_record_-_-_'] as $key=>$val){
					if($key == $file){
						if($val == 1){
							$file_verified = 1;
							break;
						}
					}
				}
				if($file_verified == 0){
					$output = shell_exec('php -l ' . $file);
					$output_array = explode(' in ', $output);
					if($output_array[0] != "No syntax errors detected"){
						$GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_modified_-_-_'] = true;
						$GLOBALS['_-_-_fileread_record_-_-_'][$file] = false;
						$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;
						$app = parsing_ERROR($output);
					}
					else{
						$GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_modified_-_-_'] = true;
						$GLOBALS['_-_-_fileread_record_-_-_'][$file] = true;

						require_once $file;
						$handler = Handler::clause_tunnel();
						if(isset($handler['error'])){
							$compact = $handler;
							echo "<div style='position:fixed; left:0; top:0; padding:20px; background:rgba(0, 0, 0, 0.7); color:#fff; width:100%; font-family: Times New Roman; font-size:16px; text-align:left; z-index:999999;'>";
							if(isset($compact['name']))
			                    echo "<c style='color: #00aeff;'>ERROR type:</c> " . $compact['name'] . "<br>";
			                if(isset($compact['file']))
			                    echo "<c style='color: #00aeff;'>FILE:</c> " . $compact['file'] . "<br>";
			                if(isset($compact['line']))
			                    echo "<c style='color: #00aeff;'>LINE:</c> " . $compact['line'] . "<br>";
			                if(isset($compact['message'])){
			                    if(isset($compact['name']))
			                        echo "<c style='color: #00aeff;'>ERROR:</c> " . $compact['message'] . "<br>";
			                    else
			                        echo "<i>" . $compact['message'] . "</i><br>";
			                }
							echo "</div>";

							$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;

							$log_message = $compact['type'] . " <------> " . $compact['file'] . " <------> " . $compact['line'] . " <------> " . $compact['message'];
							vortex_log_library::generate_log_record($log_message);
						}
					}
				}
				else{
					require_once $file;
					$handler = Handler::clause_tunnel();
					if(isset($handler['error'])){
						$compact = $handler;
						echo "<div style='position:fixed; left:0; top:0; padding:20px; background:rgba(0, 0, 0, 0.7); color:#fff; width:100%; font-family: Times New Roman; font-size:16px; text-align:left; z-index:999999;'>";
						if(isset($compact['name']))
		                    echo "<c style='color: #00aeff;'>ERROR type:</c> " . $compact['name'] . "<br>";
		                if(isset($compact['file']))
		                    echo "<c style='color: #00aeff;'>FILE:</c> " . $compact['file'] . "<br>";
		                if(isset($compact['line']))
		                    echo "<c style='color: #00aeff;'>LINE:</c> " . $compact['line'] . "<br>";
		                if(isset($compact['message'])){
		                    if(isset($compact['name']))
		                        echo "<c style='color: #00aeff;'>ERROR:</c> " . $compact['message'] . "<br>";
		                    else
		                        echo "<i>" . $compact['message'] . "</i><br>";
		                }
						echo "</div>";

						$GLOBALS['_-_-_Vortex_Error_-_-_'] = true;

						$log_message = $compact['type'] . " <------> " . $compact['file'] . " <------> " . $compact['line'] . " <------> " . $compact['message'];
						vortex_log_library::generate_log_record($log_message);
					}
				}
			}

		}

	}

?>