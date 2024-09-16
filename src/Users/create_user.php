<?php
include "process_create_user.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body>
    <div class="general">
    <form method="post" id="formulario">
        <label for="name">Introduce un nombre de usuario</label>
        <input type="text" name="name" id="name" placeholder="Nombre de usuario" required style="width: 400px;">
        <label for="password">Introduce la contraseña</label>
        <div class="password">
            <input type="password" required name="password" id="password" placeholder="Introduce la contraseña">
            <button id="first">👀</button>
        </div>
        <label for="confirm">Confirma la contraseña</label>
        <div class="password">
            <input type="password" required name="confirm" id="confirm" placeholder="Confirma la contraseña">
            <button id="second">👀</button>
        </div>
        <label for="email">Introduce el correo</label>
        <input type="email" required name="email" id="email" placeholder="Introduce tu correo" style="width: 400px;">

        <div>
        <input type="submit" value="Crear cuenta" id="submit">
        <input type="button" value="Comprobar datos" id="check">
        </div>
        
        <div id="errorMessage">
            <?php
            if (isset($_SESSION['success'])) {
                unset($_SESSION['success']);
                unset($_SESSION['error']);
            } else {
                echo "<p>" . $_SESSION['error'] . "</p>";
            }
            unset($_SESSION['success']);
            unset($_SESSION['error']);

            ?>
        </div>
    </form>
    </div>
    <script src="../javascript/checkLogin.js"></script>
    <script src="../javascript/showPassword.js"></script>
    <script src="../javascript/validateUser.js"></script>
</body>

</html>