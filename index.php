<?php

    require_once("config.php");
    require_once("autoload.php");
    require_once("utils/errorLogging.php");


    $url = ( isset($_GET['url']) ) ? $_GET['url'] : "Main/index"; 
    //echo $url."</br>";
    //Dividiendo la url
    $url = explode("/", $url);
    //print_r($url);

    $controller = (isset($url[0])) ? $url[0] : "Main";
    //echo $controller."</br>";

    $method = (isset($url[1])) ? $url[1] : "index";
    //echo $method."</br>";

    //Si me enviaron parametros en la peticion por GET 
    $params=array();
    for ($i=2; $i<count($url); $i++) 
    { 
        $params[]=$url[$i];
    }

    //Se agregan los parametros enviados por POST
    $params=array_merge($params, $_POST);
    //print_r($params);

    $controller_path = "./controllers/".$controller.".php";
    if (file_exists($controller_path)) 
    {
        require_once($controller_path);
        $controller = "controllers\\".$controller;
        $controlador = new $controller();

        if (method_exists($controlador, $method)) 
        {
            if (count($params)>0) 
            {
                //Se ejecuta el metodo del controlador con parametros
                $controlador->$method($params);
            }
            else 
            {
                //Se ejecuta el metodo del controlador sin parametros
                $controlador->$method();
            }
        }
        else
        {
            //Invocando al controlador que genera las paginas
            throw new Exception("No existe el metodo".$method."en el controlador".$controller, 1);  
        }
    }
    else
    {
        throw new Exception("Error procesando la petición: No existe el controlador a ejecutar", 1);
        
    }
?>