<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Por favor, rellena todos los campos.";
        header('Location: create_user.php');
        exit();
    }

    try {
include '/var/www/html/connection.php';

        $checkUsername = $con->prepare("SELECT username FROM usuarios WHERE username = :username");
        $checkUsername->execute([':username' => $name]);

        $checkEmail = $con->prepare("SELECT email FROM usuarios WHERE email = :email");
        $checkEmail->execute([':email' => $email]);

        if ($checkUsername->rowCount() > 0) {
            $_SESSION['error'] = "El nombre de usuario ya existe. Por favor, elige otro.";
            header('Location: create_user.php');
            exit();
        } else if ($checkEmail->rowCount() > 0) {
            $_SESSION['error'] = "El correo ya existe. Por favor, elige otro.";
            header('Location: create_user.php');
            exit();
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $statement = $con->prepare("INSERT INTO usuarios (username, password, email) VALUES (:username, :password, :email)");
            if (
                $statement->execute([
                    ':username' => $name,
                    ':password' => $hashedPassword,
                    ':email' => $email
                ])
            ) {
                $_SESSION['success'] = 'Usuario registrado correctamente.';

                $id = $con->prepare("SELECT id_usuario FROM usuarios WHERE username = :username");
                $id->execute([':username' => $name]);

                if ($id->rowCount() == 1) {
                    $row = $id->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['id'] = $row['id_usuario'];
                }

                $_SESSION['username'] = $name;
                header('Location: ../home.php');
                exit();
            } else {
                $_SESSION['error'] = 'Error al registrar el usuario. Inténtalo de nuevo.';
                header('Location: create_user.php');
                exit();
            }
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error con la base de datos: ' . $e->getMessage();
        header('Location: create_user.php');
        exit();
    }
}
?>
