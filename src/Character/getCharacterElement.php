<?php
session_start();

    include '/var/www/html/connection.php';
    $statement=$con->prepare('select * from personajes where id_personaje=:id_personaje');
    $statement->execute([':id_personaje'=>$_SESSION['Personaje_ID']]);
    $character=$statement->fetch(PDO::FETCH_ASSOC);

?>