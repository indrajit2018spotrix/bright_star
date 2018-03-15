<?php

	namespace app\http\illuminate\controller;
	use helper\vortex_session_library;

	class SessionController{

		private $compact;

		public function __construct($compact){
			$this->compact = $compact;
		}

		public function session_data(){

			return vortex_session_library::session_init([
				"user_id"			=>	"mg54t9j2cyj8t4cj8r3489rcjx4hcwec4e45cf34cr78c34c7",
				"user_password"		=>	"K111919518r"
			]);

		}

	}

?>