<?php
require_once("Utils/errorLogging.php");

use libs/CookieUtils;
echo "<pre>";

$onj = new CookieUtils();
var_dump($obj->getAllCookies()); 

$obj->set("preferencia","pepeeeeeeeee");

var_dump($obj->getAllCookies());
echo $obj->get("preferencia");
?>