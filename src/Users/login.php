<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/login.css">
</head>

<body>
    <div class="general">
    <form action="process_login.php" method="post" id="formulario">
        <label for="username">Introduce tu nombre de usuario</label>
        <input type="text" name="username" id="username" style="width: 400px;" placeholder="Introduce el nombre de usuario">
        <label for="password">Introduce tu contraseña</label>
        <div class="password">
        <input type="password" name="password" id="password" placeholder="Introduce la contraseña">
        <button id="first">👀</button>
        </div>
        <input type="submit" value="Iniciar Sesión">
    </form>
    <div>
        <p id="errorMessage"><?php echo htmlspecialchars($error); ?></p>
    </div>
    </div>
    <script src="../javascript/showPassword.js"></script>
</body>

</html>
