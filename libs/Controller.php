<?php
namespace libs;

abstract class Controller{
	protected $view;
	protected $model;
	protected $errores;

	public function __construct(){
		//Iniciamos la sesion PHP
		Session::init();
		$this->view = new View();
		$this->loadModel();
		$errors=array();
	}


	private function loadModel(){
		$class= get_class($this);
		$model = explode("\\",$class)[1]."Model";
		$modelPath = "models".DS.$model.".php";

		$model = "models\\".$model;
		if(file_exists($modelPath)){
			require_once($modelPath);
			$this->model = new $model();
		}
		else{
			throw new \Exception("No existe el modelo $modelPath", 1);
			
		}
	}

	public function getErrorstoString(){
		return implode("\n", $this->errores);
	}

	public function getErrores(){
		return $this->errores;
	}
}
?>