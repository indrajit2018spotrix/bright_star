<?php

	namespace app\http\illuminate\model;
	use app\vortex\library\PHP_ES\ES_Implementation;

	class WelcomeModel{

		public static function lobster($parameters){
			
			return [
						"elasticsearch"		=>	ES_Implementation::init_es('elastic_69'),
						"parameters"		=>	$parameters
			];

		}

	}

?>