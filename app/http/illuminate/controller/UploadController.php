<?php

	namespace app\http\illuminate\controller;
	use helper\vortex_file_upload_library;

	class UploadController{

		private $compact;

		public function __construct($compact){
			$this->compact = $compact;
		}

		public function upload_file(){

			$file_array = [
				"item_img"	=>	[
									"storage_option"	=>	1,	#1=storage; 2=asset
									"path"				=>	"uploads/",
									"thumbnail"			=>	true,
									"thumbnail_path"	=>	"uploads/thumbs/",
									"thumbs_max_width"	=>	400,
									"allowed_types"		=>	["jpg","jpeg","png","bmp"]
				]
			];

			return vortex_file_upload_library::upload_files($file_array);
			// return $file_array;

		}

	}

?>