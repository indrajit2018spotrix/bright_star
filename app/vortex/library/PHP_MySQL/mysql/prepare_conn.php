<?php

	namespace app\vortex\library\PHP_MySQL\mysql;
	use config\vortex\Host_Config;

	class prepare_conn{

		private $hostname, $username, $database, $password;

		public function __construct($selected_mysql){

			$mysql_credentials = Host_Config::batch();
			$db_arr = $mysql_credentials[$selected_mysql];

			$this->db_vars($db_arr);

		}

		private function db_vars($db_arr){

			$this->hostname = $db_arr["hostname"];
			$this->username = $db_arr["username"];
			$this->password = $db_arr["password"];
			$this->db_name = $db_arr["db_name"];

		}

		public function connect_db($connObj){

			return $this->mysql_db_connect($connObj);

		}

		private function mysql_db_connect($connObj){
			return $connObj->db_connect($this->hostname, $this->username, $this->password, $this->db_name);
		}

	}

?>