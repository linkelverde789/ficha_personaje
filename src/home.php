<?php
session_start();
include 'Character/obtenerPersonajes.php';
include 'funciones_home.php';
include 'security.php';
if (isset($_SESSION['Personajes_ID'])) {
    unset($_SESSION['Personaje_ID']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exito</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/home.css">
    <link href="https://fonts.googleapis.com/css2?family=UnifrakturMaguntia&display=swap" rel="stylesheet">
</head>

<body>
    <nav>
        <ul class="nav-links">
            <li><a href="../Character/createCharacter.php">Crear Personaje</a></li>
        </ul>
    </nav>
    <div>
        <?php
        if (home($_SESSION['id']) === 0) {
            echo '<h1>¡Aquí aparecerán tus personajes cuando crees alguno!</h1>';
        } else {
            echo '<h1>Tus personajes</h1>';
            obtenerPersonajes($_SESSION['id']);
        }
        ?>
    </div>
</body>

</html>