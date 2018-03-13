<?php

	error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 0);

    define('_-_-_APP_CONSTANT_-_-_', "==kjg783475c47589347kxc9kru=934cukr=8ry89");

    function generate_log_record($log_message){
        chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
        $log_file_name = $GLOBALS['_-_-_syatem_time_-_-_']['_-_-_current_date_-_-_'];
        $log_file_extension = $GLOBALS['_-_-_manifest_-_-_']['_-_-_log_file_extension_-_-_'];
        $log_folder = 'storage/logs/';

        $current_time = $GLOBALS['_-_-_syatem_time_-_-_']['_-_-_current_time_micro_-_-_'];

        if(!file_exists($log_folder))
            mkdir($log_folder, 0777, true);
        if(!file_exists($log_folder . "" . $log_file_name . "" . $log_file_extension)){
            $handle = fopen($log_folder . "" . $log_file_name . "" . $log_file_extension, 'w');
            fclose($handle);
        }

        $log_message = $current_time . " ###### " . $log_message . "\n\n";

        if($GLOBALS['_-_-_manifest_-_-_']['_-_-_delete_previous_logs_-_-_']){
        	$file_list = scandir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_'] . "/storage/logs/");
        	foreach($file_list as $key=>$val){
        		$file_name_ext = explode('.', $val);
        		if(".".end($file_name_ext) == $GLOBALS['_-_-_manifest_-_-_']['_-_-_log_file_extension_-_-_']){
        			if($file_name_ext[0] != $log_file_name){
        				unlink($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_'] . "/storage/logs/" . $val);
        			}
        		}
        	}
        }

        file_put_contents($log_folder . "" . $log_file_name . "" . $log_file_extension, $log_message, FILE_APPEND | LOCK_EX);
    }

    function System_Shutdown(){

        $isError = false;
        if($error = error_get_last()){
            switch($error['type']){
                case E_ERROR:
                case E_CORE_ERROR:
                case E_COMPILE_ERROR:
                case E_USER_ERROR:
                    $isError = true;
                    break;
            }
        }

        if($isError && !isset($GLOBALS['_-_-_Vortex_Error_-_-_'])){
            $compact = $error;

            if(!file_exists("resource/app/500.blade.php")){
                require_once "resource/app/500.blade.php";
            }
            else{
                echo "<div style='padding:100px; margin:0;'>";
                echo "<center>";
                echo "<br><br><h1>500 Internal Error</h1><br>";
                if(isset($compact['name']))
                    echo "<b>ERROR type:</b> <i><u>" . $compact['name'] . "</u></i><br>";
                if(isset($compact['file']))
                    echo "<b>FILE:</b> <i><u>" . $compact['file'] . "</u></i><br>";
                if(isset($compact['line']))
                    echo "<b>LINE:</b> <i>" . $compact['line'] . "</i><br>";
                if(isset($compact['message'])){
                    if(isset($compact['name']))
                        echo "<b>ERROR:</b> <i><u>" . $compact['message'] . "</u></i><br>";
                    else
                        echo "<i>" . $compact['message'] . "</i><br>";
                }
                echo "</center>";
                echo "</div>";
            }

            $log_message = $compact['name'] . " <------> " . $compact['file'] . " <------> " . $compact['line'] . " <------> " . $compact['message'];

            generate_log_record($log_message);

        }

        if($GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_modified_-_-_']){
            chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
            if(!file_exists($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_'])){
                $handle = fopen($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_'], 'w');
                fclose($handle);
            }
            $previous_record = parse_ini_file($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_']);

            if(sizeof($previous_record) > 0){
                foreach($previous_record as $key_prev=>$val_prev){
                    $key_found = 0;
                    foreach($GLOBALS['_-_-_fileread_record_-_-_'] as $key_current=>$val_current){
                        if($key_prev == $key_current){
                            $key_found = 1;
                            break;
                        }
                    }

                    if($key_found == 0)
                        $new_record[$key_prev] = $previous_record[$val_prev];
                }
            }

            if(isset($new_record))
                array_push($GLOBALS['_-_-_fileread_record_-_-_'], $new_record);

            $ini_content = '';
            ksort($GLOBALS['_-_-_fileread_record_-_-_']);
            foreach($GLOBALS['_-_-_fileread_record_-_-_'] as $key=>$val){
                $ini_content = $ini_content . "" . $key . "=" . $val . "\n";
            }

            // chdir($GLOBALS['manifest']['DOCUMENT_ROOT']);
            file_put_contents($GLOBALS['_-_-_path_-_-_']['_-_-_ini_path_-_-_'] . "" . $GLOBALS['_-_-_system_syntax_batch_-_-_']['_-_-_file_-_-_'], $ini_content, LOCK_EX);
            // chdir($_SERVER['DOCUMENT_ROOT']);
        }
    }

    register_shutdown_function('System_Shutdown');

	require_once "config/app.php";

?>