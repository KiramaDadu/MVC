<?php
namespace models;

use libs\DBConexion;

class InventarioModel {
	public $dia;
	public $produccion;
	public $demanda;
	public $ventas;
	public $inventario_inicial;
	public $inventario_final;
	public $costo_produccion;
	public $costo_faltante;
	public $costo_inventario;
	public $costo_total;

	public function __construct(){
		$this->costo_faltante = 0.0;
	}

	public function obtenerInventarioDia($dia){
		//Solicito el unico objeto de conexion que usaran todas la clases, usando el patron Singleton		
		$con = DBConexion::getInstance();

		$inventarios= $con->executeQuery('SELECT * FROM inventario WHERE inventario.dia=?;',
			array($dia), __NAMESPACE__.'\InventarioModel');

		return $inventarios;
	}

	public function crearInventario($dia, $produccion, $demanda){
		//Dia de trabajo en el ingenio.
		$this->dia=$dia;
		//Produccion y demanda del dia
		$this->produccion = $produccion;
		$this->demanda = $demanda;
		

		//Inventario inicial
		if($this->dia == 1){
			$this->inventario_inicial = $this->produccion;
		}
		else{
			//Obteniendo el inventario del dia anterior
			
			$consulta =$this->obtenerInventarioDia($this->dia - 1);
			if(count($consulta)==0){
				throw new \Exception(sprintf("No existe un inventario para el dia %s, por tanto, no se puede seguir", $dia-1));
				
			}
			$this->inventario_inicial = $consulta[0]->inventario_final + $this->produccion;


		}
		//Inventario final del dia
		$this->inventario_final = max(0, $this->inventario_inicial - $this->ventas);

		//Calculando las ventas del dia
		$this->ventas = min($this->inventario_inicial, $this->demanda);

		//Costo produccion
		$this->costo_produccion = 5 * $this->produccion;

		//Costo faltante
		if($this->demanda > $this->inventario_inicial){
			$this->costo_faltante = 6 * ($this->demanda - $this->inventario_inicial);
		}

		//Costo inventario
		$this->costo_inventario = 2 * (($this->inventario_inicial + $this->inventario_final) / 2);

		//Costo total
		$this->costo_total = $this->costo_produccion + $this->costo_faltante + $this->costo_inventario;

		
		//Guardando el inventario del dia
		$this->guardar();
	}

	public function guardar(){
		//Solicito un objeto conexion, usando el patron Singleton
		$con = DBConexion::getInstance();
		$params = array(			
			$this->dia,
			$this->demanda,
			$this->produccion,
			$this->inventario_inicial,
			$this->inventario_final,
			$this->ventas,
			$this->costo_produccion,
			$this->costo_faltante,
			$this->costo_inventario,
			$this->costo_total
			);

		$sql1 = vsprintf("INSERT INTO inventario VALUES(%s, %s, %s,%s,%s, %s, %s,%s,%s,%s);", $params);
		
		$con->executeUpdate(array($sql1));

	}

	public function listarInventarios(){
		$con= DBConexion::getInstance();
		if(is_null($con)){
			throw new Exception("Error en la conexión a la base de datos, verifique el registro de errores de su sistema", 1);
		}
		$inventarios = $con->executeQuery('SELECT * FROM inventario;', null, __NAMESPACE__.'\InventarioModel');
	    return $inventarios;

	}
	
}

?>