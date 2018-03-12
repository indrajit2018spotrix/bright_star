<?php

	namespace app\vortex\library\PHP_MySQL\mysql;

	class conn{

		private $connect, $db_conn;

		public function __construct(){

			$this->connect = FALSE;
			$this->db_conn = FALSE;

		}

		public function db_connect($hostname, $username, $password, $db_name){
			return $this->mysql_connection($hostname, $username, $password, $db_name);
		}

		private function mysql_connection($hostname, $username, $password, $db_name){

			$this->db_conn = mysqli_connect($hostname, $username, $password, $db_name);

			return $this->db_conn;

		}

		public function __destruct(){
			mysqli_close($this->db_conn);
		}

	}

?>