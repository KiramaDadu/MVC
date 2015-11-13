<?php
 namespace controllers;
 use libs\Controller;
 class Index extends Controller{

 	function __construct(){
 		parent::__construct();
 	}
 	public function index(){
 		$a= explode("\\", get_class($this))[1];
 		echo $a;
 		$this -> errores[0]="pepito no vino a la escuela";
 		$this -> view -> render ($a, "index", $this->getErrores());
 	
 	}
 }
 ?>
 