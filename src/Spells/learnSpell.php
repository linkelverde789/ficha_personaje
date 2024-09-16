<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $spell_id = $_POST['hechizos'];

    try {
        include '/var/www/html/connection.php';


        $statement = $con->prepare('insert into hechizos_personajes (id_personaje, id_hechizo) values (:id_personaje, :id_hechizo)');
        $statement->execute([
            ':id_personaje' => $_SESSION['Personaje_ID'],
            ':id_hechizo' => $spell_id
        ]);



    } catch (PDOException $e) {
        $error = cleanPostgresError($e->getMessage());
        $_SESSION['error'] = $error;


    }
    header("Location: hechizos.php");
    exit();
}

function cleanPostgresError($error)
{
    $pattern = '/ERROR:\s*(.*)/i';
    if (preg_match($pattern, $error, $matches)) {
        return $matches[1];
    }
    return $error;
}
?>