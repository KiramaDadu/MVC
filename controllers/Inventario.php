<?php
	namespace controllers;	
	use libs\Controller;

	class Inventario extends Controller {

		public function __construct(){
			parent::__construct();
			
		}

		public function crear($params=array()){
			//Llamando al metodo del modelo
			if(isset($params['dia']) && isset($params['demanda']) && isset($params['produccion'])){
				$this->crearInventario($params);
			}
			//Renderizando la vista asociada
			$this->view->render(explode("\\",get_class($this))[1], "crear",$this->getErrores());
		}

		public function crearInventario($params){
			
		    $dia = $params['dia'];
		    $produccion = $params['produccion'];
		    $demanda = $params['demanda'];

		    if(!is_numeric($dia)){
		        $this->errores['dia']="Oye el dia no es un numero, no seas bobo chico";
		        
		    }
		    
		    if(!is_numeric($demanda)){
		        $this->errores['demanda']="Oye la demanda no es un numero, no seas bobo chico";
		        
		    }

		    if(!is_numeric($produccion)){
		        $this->errores['produccion']="Oye la produccion no es un numero, analiza";
		        
		    }

		    if(count($this->errores) ==0 ){
		    	try{
		        	$this->model->crearInventario($dia, $produccion, $demanda);
		    	}
		    	catch(\Exception $e){
					$this->errores['global']=$e->getMessage();
				}
		    }
				
		}

		public function Listas($params=array()){
			$inventarios = $this->model->listarInventarios();
			$this->view->render(explode("\\",get_class($this))[1],"listar",$inventarios,$this->getErrores());
		}
		
	}

?>