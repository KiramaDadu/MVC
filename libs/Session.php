<?php
namespace libs;
class Session{
	static function init(){
		@session_start();
	}

	static function destroy(){
		session_destroy();
	}

	static function setValue($clave, $valor){
		$_SESSION[$clave] = $valor;
	}

	static function getValue($clave){
		return $_SESSION[$clave];
	}

	static function exists(){
		if(sizeof($_SESSION) > 0)
			return true;
		return false;
	}
}
?>