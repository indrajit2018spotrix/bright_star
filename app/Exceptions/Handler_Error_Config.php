<?php

	error_reporting(0);

	class Turbo_Error{

		public static function clause_point($error){

	    	require_once "config/view.php";

			View::display_view('../assets/500', $error);
			exit();

		}
	}

?>