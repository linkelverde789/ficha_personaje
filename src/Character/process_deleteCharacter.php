<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
    $id=$_POST['delete_id'];
    include '/var/www/html/connection.php';

        $statement = $con->prepare('delete from personajes where id_personaje=:id');
        $statement->execute([':id' => $id]);
        header('Location: ../home.php');
        unset($_SESSION['Personaje_ID']);
        exit();
}
?>