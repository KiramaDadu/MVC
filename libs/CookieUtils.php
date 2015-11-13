<?php
namespace libs;

class CookieUtils{
	const expirationTime = 3600; //Tiempo de expiracion de las cookies en segundos
	public static function get($name){
		if( isset($_COOKIE[$name])){
			return $_COOKIE[$name];
		}
		else{
			return false;
		}

	}


	public function set($name, $value, $expiration = null, $path=URL_BASE, $domain=null){
		$val = false;
		if(!headers_sent()){
			
			if(is_null($domain)){
				$domain = $_SERVER['HTTP_HOST'];
			}

			$expirationTime = self::expirationTime;
			if(is_null($expiration)){
				
				$expirationTime = 1894656000; //Expira nunca
				echo $expirationTime;
			}
			elseif(is_numeric($expiration)){
				echo "2da";
				if($expiration == -1 or $expiration ==0 )
					$expirationTime = $expiration;
				else
					$expirationTime = time()+$expiration;
			}
			else{
				echo "tercera";
				$expirationTime = strtotime($expiration);
			}

			$val = setcookie($name, $value, $expirationTime, $path, $domain);
		}

		return $val;
	}

	public function delete($name, $path="/", $domain = null){
		$val = false;
		if(!headers_sent()){
			if(is_null($domain)){
				$domain = $_SERVER['HTTP_HOST'];
			}

			$val = @setcookie($name, "", -3600, $path, $domain);
			unset($_COOKIE[$name]); 
		}
	}


	public function getAllCookies(){
		if(!empty($_COOKIE)){
			return array_keys($_COOKIE);
		}
		else{
			return false;
		}
	}

}
?>