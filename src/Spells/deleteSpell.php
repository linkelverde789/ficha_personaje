<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_hechizo'])) {
    try {

        include '/var/www/html/connection.php';


        $statement = $con->prepare('DELETE FROM hechizos_personajes WHERE id_hechizo = :id_hechizo AND id_personaje = :id_personaje');
        $statement->execute([
            ':id_hechizo' => $_POST['id_hechizo'],
            ':id_personaje' => $_SESSION['Personaje_ID']
        ]);
        header('Location: hechizos.php');
        exit();

    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
    }
} else {
    echo "Acceso no autorizado.";
}
?>