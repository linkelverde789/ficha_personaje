<?php
session_start();

if (!isset($_SESSION["id"])) {
    header('Location: /index.php');
    exit();
}

$timeLimit = 21600; //6 horas en segundos

if (isset($_SESSION["last_time"]) && (time() - $_SESSION["last_time"] > $timeLimit)) {
    session_unset();
    session_destroy();
    header('Location: /index.php');
    exit();
}
$_SESSION["last_time"] = time();
?>