<?php
function home($id)
{
    try {
        include '/var/www/html/connection.php';


        $statement = $con->prepare('select count(id_personaje) as cantidad from usuarios_personajes where id_usuario=:id_usuario');
        $statement->execute([':id_usuario'=>$id]);
        $result=$statement->fetch(PDO::FETCH_ASSOC);
        return $result['cantidad'];

    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>