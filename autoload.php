<?php

function mi_autocargador($clase) {
	$rutas = array(
				str_replace('\\', DS, RUTA_BASE.DS),
				str_replace('\\', DS, RUTA_BASE.DS."libs".DS),
				str_replace('\\', DS, RUTA_BASE.DS."models".DS),
				str_replace('\\', DS, RUTA_BASE.DS."controllers".DS),
				str_replace('\\', DS, RUTA_BASE.DS."views".DS),
			);
	
	$class="";
	$flag= false;
	$index=0;
	for($i = 0; $i<count($rutas) && $flag!=True ;$i++){

		$class = $rutas[$i].$clase.'.php';
		
		if(file_exists($class)){			
			$flag=true;
		}		
	}
   	
   	if ($flag==false){
   		throw new Exception("Fichero $clase no existe");
   	}
   	require_once($class);
    
}

spl_autoload_register('mi_autocargador');

