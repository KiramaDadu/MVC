<?php

namespace libs;
use \PDO;
class DBConexion{
	private $host="localhost";
	private $port="3306";
	private $user ="root";
	private $pass= "root";
	private $dbname="inventario_db";
	public static $driver = "mysql";

	private static $instance = null;
	private $pdo = null;

	public function __construct(){
		try {
			$dsn = sprintf("%s:host=%s;dbname=%s",self::$driver, $this->host, $this->dbname);
		    $this->pdo = new PDO($dsn, $this->user, $this->pass, array(
			    PDO::ATTR_PERSISTENT => true, //Usamos conexiones persistentes para optimizar la interaccion con el SGBD
			    PDO::ATTR_TIMEOUT=>30  //Tiempo limite de espera para establecer conexion con el SGBD
			));		
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Fuerza la lanzamiento de excepciones SQL

		} catch (PDOException $e) {
			/*Loguear el error*/
			manejadorExcepciones($e);
			
		    TipoResultado::$codigo = -1;
		    TipoResultado::$mensaje = "Error: ".$e->getMessage();		    
		}
		
	}

	/**
     * Singleton design pattern
     */
    public static function getInstance() {
        if (is_null(self::$instance) || !(self::$instance instanceof DBConexion)) {
            self::$instance = new DBConexion();            
        }
        //Si no se pudo crear la conexion a la base de datos el objeto conexion sera nulo
        if(is_null(self::$instance->pdo))
        	self::$instance = null;

        return self::$instance;
    }

    /* Evitamos el clonaje del objeto. Patrón Singleton */

    private function __clone() {}

	public function executeQuery($sqlString, $params = array(), $class=null){
		

		$objetos = array();
		//Preparamos la consulta SQL
		$sentencia = $this->pdo->prepare($sqlString);

		if(is_null($class)){
			$sentencia->setFetchMode(PDO::FETCH_OBJ);				
		}
		else{
			$sentencia->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $class);
		}

		//Si no hay parametros en la consulta, la ejecuto normalmente, no utilizo consulta preparada
		if(count($params) == 0  || is_null($params)){
			if(!$sentencia->execute()){
				/*Loguear el error en fichero de logs*/
				logError(sprintf("Error (%s): %s",$sentencia->errorCode, $sentencia->errorInfo), dirname(__FILE__),"");
				
				TipoResultado::$codigo = -1;
		    	TipoResultado::$mensaje = sprintf("Error (%s): %s",$sentencia->errorCode, $sentencia->errorInfo);
				$this->destroy();
				return null;
			}
		}
		else{
			//Sino ejecuto consultas preparadas, que aumentan el rendimiento, pues el gestor de base de datos
			//prepara compila y optimiza la consulta una sola vez y luego la ejecuta tantas veces se realice
			//la peticion
			
			if(!$sentencia->execute($params)){
				/*Loguear el error en fichero de logs*/
				logError(sprintf("Error (%s): %s",$sentencia->errorCode, $sentencia->errorInfo), dirname(__FILE__),"");
				TipoResultado::$codigo = -1;
		    	TipoResultado::$mensaje = sprintf("Error (%s): %s",$sentencia->errorCode, $sentencia->errorInfo);
				$this->destroy();
				return null;
			}
		}



		//Se retornan las filas de la tabla obtenidas en un arreglo de objetos
		while ($fila = $sentencia->fetch()) {
		    $objetos[]=$fila;
		}

		return $objetos;
	}

	/**
	* Metodo usado para realiza consultas de insercion, actualizacion y eliminacion
	* Incluso varias consultas pasadas en el parametro
	*/
	public function executeUpdate($sqlString){
		//Operaciones de insercion, modificacion o eliminacion
		try {
			$this->pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,FALSE);
			//Se inicia una transaccion SQL para ejecutar una o varias consultas
			$this->pdo->beginTransaction();
			foreach ($sqlString as $sql){
				//Se realizan las consultas pasadas en el parametros dentro de la misma transaccion				
				$this->pdo->exec($sql);

			}
			//Confirma toda la transaccion al gestor de bases de datos
			$this->pdo->commit();
			return true;
		  
		} catch (PDOException $e) {
			
			$this->pdo->rollBack();
			$this->destroy();

			/*Loguear el error en fichero de logs*/
			manejadorExcepciones($e);
			TipoResultado::$codigo = -1;
	    	TipoResultado::$mensaje = sprintf("Error: %s",$e->getMessage());
			return false;
			
		}
	}

	public function destroy(){
		unset($this->pdo);
		$this->pdo =null;
		
	}
}

?>