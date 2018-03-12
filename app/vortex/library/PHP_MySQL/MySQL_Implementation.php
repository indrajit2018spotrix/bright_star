<?php

	namespace app\vortex\library\PHP_MySQL;
	use app\vortex\library\PHP_MySQL\mysql\prepare_conn;
	use app\vortex\library\PHP_MySQL\mysql\conn;

	class MySQL_Implementation{

		public static $connObj;

		public static function MySQL_Connect($selected_mysql){

			$prepare_connObj = new prepare_conn($selected_mysql);
			MySQL_Implementation::$connObj = new conn();

			return $prepare_connObj->connect_db(MySQL_Implementation::$connObj);

		}

		public static function MySQL_Connection_Close(){

			unset(MySQL_Implementation::$connObj);

		}

	}

?>