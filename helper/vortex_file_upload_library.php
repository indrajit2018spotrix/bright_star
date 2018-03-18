<?php

	namespace helper;
	use helper\vortex_image_resize_library;

	if(!defined('_-_-_APP_CONSTANT_-_-_')){
		die();
	}

	class vortex_file_upload_library{

		public static function upload_files($file_array){

			$response_array = [];

			if(!is_array($file_array)){
				return [
					"success"	=>	0,
					"error"		=>	1,
					"message"	=>	"Delivered parameter in not an array."
				];
			}
			elseif(empty($file_array)){
				return [
					"success"	=>	0,
					"error"		=>	1,
					"message"	=>	"Delivered array in empty."
				];
			}
			else{
				$array_format_error = 0;
				$break = false;
				foreach($file_array as $key=>$val){
					if(isset($_FILES[$key]["name"]) && $_FILES[$key]["tmp_name"]!=""){
						if(count($_FILES[$key]["name"])<0){
							$response_array = [
								"success"	=>	0,
								"error"		=>	1,
								"message"	=>	"No data found for files with name '".$key."'"
							];
							$array_format_error = 1;
							$break = true;
						}
						elseif(!isset($val["storage_option"]) && !isset($val["path"])){
							$response_array = [
								"success"	=>	0,
								"error"		=>	1,
								"message"	=>	"Wrong array format. 'storage_option' & 'path' are mandatory."
							];
							$array_format_error = 1;
							$break = true;
						}
						elseif(!isset($val["storage_option"])){
							$response_array = [
								"success"	=>	0,
								"error"		=>	1,
								"message"	=>	"Wrong array format. 'storage_option' is mandatory."
							];
							$array_format_error = 1;
							$break = true;
						}
						elseif(!isset($val["path"])){
							$response_array = [
								"success"	=>	0,
								"error"		=>	1,
								"message"	=>	"Wrong array format. 'path' is mandatory."
							];
							$array_format_error = 1;
							$break = true;
						}
						elseif(isset($val["allowed_types"])){
							if(!is_array($val["allowed_types"])){
								$response_array = [
									"success"	=>	0,
									"error"		=>	1,
									"message"	=>	"'allowed_types' is not array."
								];
								$array_format_error = 1;
								$break = true;
							}
							elseif(empty($val["allowed_types"])){
								$response_array = [
									"success"	=>	0,
									"error"		=>	1,
									"message"	=>	"'allowed_types' is empty."
								];
								$array_format_error = 1;
								$break = true;
							}
						}
					}
					else{
						$response_array = [
							"success"	=>	0,
							"error"		=>	1,
							"message"	=>	"No data found for files with name '".$key."'"
						];
						$array_format_error = 1;
						$break = true;
					}

					if($break)
						break;
				}

				if($array_format_error == 1)
					return $response_array;
				else{
					$cto = 0;
					$upload_count = 0;
					$failure_count = 0;
					$error_log = [];
					$upload_links = [];
					$response_array["upload_details"] = [];
					chdir($GLOBALS['_-_-_manifest_-_-_']['_-_-_DOCUMENT_ROOT_-_-_']);
					foreach($file_array as $key=>$val){
						if($val["storage_option"] == 1)
							$dir = 'storage/'.$val["path"];
						else
							$dir = 'asset/'.$val["path"];

						$error_spotted = 0;
						$total_uploaded = 0;
						$upload_links[$key] = array();

						foreach($_FILES[$key]['name'] as $file_key=>$file_val){
							$cto++;
							$format_matches = 1;

							$fileName = $_FILES[$key]["name"][$file_key];
							$fileTmpLoc = $_FILES[$key]["tmp_name"][$file_key];
							$fileType = $_FILES[$key]["type"][$file_key];
							$fileSize = $_FILES[$key]["size"][$file_key];
							$fileErrorMsg = $_FILES[$key]["error"][$file_key];
							$kaboom = explode(".", $fileName);
							$fileExt = end($kaboom);
							$hashed_name = sha1(str_shuffle(uniqid("__nc7834cyr8734jcyy34yu34h6cyr7i__", true).rand(100000, 999999).date("DdgNmMhHisueIY")));
							$db_file_name = $hashed_name.".".$fileExt;

							if(isset($val["allowed_types"])){
								$format_matches = 0;
								for($index=0; $index<sizeof($val["allowed_types"]); $index++){
									if(strcasecmp($fileExt,$val["allowed_types"][$index]) == 0){
										$format_matches = 1;
										break;
									}
								}
							}

							if($format_matches == 1){
								$file_info_error = 0;
								$filetype_component = explode('/', $fileType);

								if(strcasecmp($filetype_component[0],'image') == 0){
									if(isset($val["thumbnail"])){
										if($val["thumbnail"]){
											if(!isset($val["thumbnail_path"]) && !isset($val["thumbs_max_width"])){
												$error_spotted++;
												$file_info_error = 1;
												$error_data = [
													"name"		=>	$key,
													"file_name"	=>	$fileName,
													"error"		=>	"'thumbnail_path' & 'thumbs_max_width' not mentioned."
												];
												array_push($error_log, $error_data);
											}
											elseif(!isset($val["thumbnail_path"])){
												$error_spotted++;
												$file_info_error = 1;
												$error_data = [
													"name"		=>	$key,
													"file_name"	=>	$fileName,
													"error"		=>	"'thumbnail_path' not mentioned."
												];
												array_push($error_log, $error_data);
											}
											elseif(!isset($val["thumbs_max_width"])){
												$error_spotted++;
												$file_info_error = 1;
												$error_data = [
													"name"		=>	$key,
													"file_name"	=>	$fileName,
													"error"		=>	"'thumbs_max_width' not mentioned."
												];
												array_push($error_log, $error_data);
											}
											else{
												if($val["storage_option"] == 1)
													$thumb_dir = 'storage/'.$val["thumbnail_path"];
												else
													$thumb_dir = 'asset/'.$val["thumbnail_path"];
												$thumbs_max_width = $val["thumbs_max_width"];
											}
										}
									}
								}

								if($file_info_error == 0){

									if(!file_exists($dir))
										mkdir($dir, 0777, true);

									if(isset($val["thumbnail"])){
										if($val["thumbnail"]){
											if(!file_exists($thumb_dir))
												mkdir($thumb_dir, 0777, true);
										}
									}
									
									$moveResult = move_uploaded_file($fileTmpLoc, $dir."/".$db_file_name);

									if($moveResult == TRUE){
										$total_uploaded++;
										$uploaded_file_data['file'] = $dir.$db_file_name;

										if(isset($val["thumbnail"])){
											if($val["thumbnail"]){
												$uploaded_file_data['thumb'] = $thumb_dir.$db_file_name;
												$target_file = $dir.$db_file_name;
												$resized_file = $thumb_dir.$db_file_name;
												$hmax = round($thumbs_max_width*0.7);
												$resize_image = vortex_image_resize_library::img_resize($target_file, $resized_file, $thumbs_max_width, $hmax, $fileExt);
											}
										}

										array_push($upload_links[$key], $uploaded_file_data);
									}
									else{
										$error_spotted++;
										$error_data = [
											"name"		=>	$key,
											"file_name"	=>	$fileName,
											"error"		=>	"File wasn't uploaded due to some internal errors. Please try again later."
										];
										array_push($error_log, $error_data);
									}
								}
							}
							else{
								$error_spotted++;
								$error_data = [
									"name"		=>	$key,
									"file_name"	=>	$fileName,
									"error"		=>	"File-type not allowed."
								];
								array_push($error_log, $error_data);
							}
						}

						$upload_count += $total_uploaded;
						$failure_count += $error_spotted;

						$upload_statistics[$key] = [
							"uploaded"	=>	$total_uploaded,
							"failed"	=>	$error_spotted
						];
					}

					$response_array["upload_details"] = $upload_statistics;

					if($upload_count > 0){
						$response_array["success"] = 1;
						$response_array["error"] = 0;
						$response_array["uploaded"] = $upload_count;
						$response_array["failed"] = $failure_count;
						// $response_array["upload_statistics"] = $upload_statistics;
						$response_array["files"] = $upload_links;
						$response_array["message"] = "File upload completed.";
					}
					else{
						$response_array["success"] = 0;
						$response_array["error"] = 1;
						$response_array["message"] = "No file was uploaded.";
					}

					if(sizeof($error_log) > 0)
						$response_array['error_log'] = $error_log;

					return $response_array;
				}
			}

		}
		
	}

?>