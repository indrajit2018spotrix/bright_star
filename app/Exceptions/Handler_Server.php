<?php

	error_reporting(0);

	class Turbo_Server{

		public static function clause_point($db_conn){

			if(mysqli_error($db_conn)){
		    	require_once "config/view.php";

				$error = mysqli_error($db_conn);
				View::display_view('../assets/500', $error);
				exit();
		    }
		   	
		}
	}

?>