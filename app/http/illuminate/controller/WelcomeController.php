<?php

	namespace app\http\illuminate\controller;
	use config\vortex\view;
	use config\vortex\Model;

	class WelcomeController{

		private $compact;

		public function __construct($compact){
			$this->compact = $compact;
		}

		public function welcome(){

			$this->compact['userID'] = "hn87584jc589c";
			$this->compact['bookID'] = "BOOK_133";
			// $this->compact['message'] = WelcomeModel::lobster();
			$model_returns = Model::TriggerModel("WelcomeModel@lobster", ["Serial_No"=>"USER_001", "Registration"=>"5j346h57896423j578du35d72"]);

			if($model_returns['model_success'] == 1){
				$this->compact['__data__'] = $model_returns['model_data'];

				$view_OBJ = new view();
				return $view_OBJ->render_view("welcome", $this->compact);
			}
			
		}

	}

?>