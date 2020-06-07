<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function toCamelCase($input, $separator = "-"){
        return str_replace($separator, '', ucwords($input, $separator));
    }

    spl_autoload_register(function($className){
        require_once "src/".str_replace("\\", "/", $className).".php";
    });

    $sURI = $_SERVER["REQUEST_URI"];
    $aURI = explode("/", trim($sURI));
    
    $controllerName = array_shift($aURI);
    $actionName = array_shift($aURI);
    $params = $aURI; 

    if($controllerName == null){
        $controllerName = "home";
    }

    if($actionName == null){
        $actionName = "index";
    }

    $sController    = "app\\controller\\".toCamelCase($controllerName)."Controller";
    $sMethod        = lcfirst(toCamelCase($actionName));

    $controller = new $sController();

    call_user_func_array(array($controller, $sMethod), $aURI);