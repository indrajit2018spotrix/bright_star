<?php

	namespace app\http\illuminate\controller;
	use helper\vortex_session_library;

	class SessionController{

		private $compact;

		public function __construct($compact){
			$this->compact = $compact;
		}

		public function session_data(){

			return vortex_session_library::session_terminate();

		}

	}

?>