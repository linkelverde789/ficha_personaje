<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($name) || empty($password)) {
        $_SESSION['error'] = "Por favor, rellena todos los campos.";
        header('Location: login.php');
        exit();
    }

    try {
        include '/var/www/html/connection.php';


        $statement = $con->prepare("SELECT id_usuario, password FROM usuarios WHERE username = :username");
        $statement->execute([':username' => $name]);

        if ($statement->rowCount() == 1) {
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            $hashedPassword = $row['password'];

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['id']=$row['id_usuario'];
                $_SESSION['username']=$name;

                header('Location: ../home.php');
                exit();
            } else {
                $_SESSION['error'] = "Usuario o Contraseña incorrectos.";
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Usuario o Contraseña incorrectos.";
            header('Location: login.php');
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error con la base de datos: " . $e->getMessage();
        header('Location: login.php');
        exit();
    }
}
?>
