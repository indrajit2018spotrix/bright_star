<?php

	namespace app\http\illuminate\model;
	use app\vortex\library\PHP_MySQL\MySQL_Implementation;

	class AppModel{

		public static function lobster(){
			
			return [
						"mysql"		=>	MySQL_Implementation::MySQL_Connect('mysql') OR "Connection Error."
			];

		}

	}

?>