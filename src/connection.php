<?php

$con = new PDO("pgsql:host=192.168.1.201;dbname=bdrol", "app", "app"); //hay que cambiar la IP por la que se quiera
$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>

