<?php
namespace libs;

class View{

	private $errores;
	public function render($controler, $view, $data, $errors=array()){
		$this->errores = $errors;
		$this->datos = $data;

		$view = "views".DS.$controler.DS.$view.".php";
		if(file_exists($view)){
			require_once($view);
		}
		else{
			throw new \Exception("No existe una vista asociada a esta petición: $view no existe", 1);
			
		}
	}

		public function getDatos() {
		return $this->datos;
	}

	public static function renderError($code, $param){
		/**
		* Si el codigo es 1: no existe el controlador
		* Si el codigo es 2: no existe el metodo
		* Si el codigo es 3: no existe la vista asociada
		* Si el codigo es 4: no existe el modelo asociado a la peticion
		*/
		$view = "views".DS."errorPage.php";
		switch ($code){
			case 1:
				$this->errores[0]= "No existe el controlador requerido $param";
				break;
			
			case 2:
				$this->errores[0]= "No existe el método requerido $param";
				break;
			case 3:
				$this->errores[0]= "No existe la vista asociada a este método $param";
				break;
			case 4:
				$this->errores[0]= "No existe la vista asociada a este método $param";
				break;
		}
		
		if(file_exists($view)){
			require_once($view);
		}
		else{
			throw new \Exception("No existe una vista de error", 1);
			
		}
	}
}
?>