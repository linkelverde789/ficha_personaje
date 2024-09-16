<?php
session_start();
if (isset($_GET['id'])) {
    $_SESSION['Personaje_ID'] = $_GET['id'];
    header('Location: ../CharacterSheet/ficha.php');
    exit();
} else {
    header('Location: ../home.php');
    exit();
}
?>