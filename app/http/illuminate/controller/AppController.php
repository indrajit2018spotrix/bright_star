<?php

	namespace app\http\illuminate\controller;
	use config\vortex\view;
	use config\vortex\Model;

	class AppController{

		private $compact;

		public function __construct($compact){
			$this->compact = $compact;
		}

		public function app(){

			$images = ['img16.jpg'];
			$random_index = rand(0, sizeof($images)-1);

			$this->compact['background'] = $images[$random_index];

			$model_returns = Model::TriggerModel("AppModel@lobster", NULL);

			if($model_returns['model_success'] == 1){
				$this->compact['__data__'] = $model_returns['model_data'];

				$view_OBJ = new view();
				return $view_OBJ->render_view("app/app", $this->compact);
			}

		}

	}

?>