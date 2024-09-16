<?php

function obtenerPersonajes($id_usuario){
    try {
        include '/var/www/html/connection.php';
       
        $statement = $con->prepare('SELECT id_personaje FROM usuarios_personajes WHERE id_usuario = :id_usuario');
        $statement->execute([':id_usuario' => $id_usuario]);
        $personajes = $statement->fetchAll(PDO::FETCH_ASSOC);
       
        echo '<div class="personajes">';
        foreach($personajes as $item){
            $personaje = $con->prepare("SELECT id_personaje,nombre, clase, raza, nivel FROM personajes WHERE id_personaje = :id_personaje");
            $personaje->execute([':id_personaje' => $item['id_personaje']]);
            $datosPersonaje = $personaje->fetch(PDO::FETCH_ASSOC);
            if ($datosPersonaje) {
                echo '
                <div class="personaje">
                    <h1>'.$datosPersonaje['nombre'].'</h1>
                    <h2>'.$datosPersonaje['raza'].' '.$datosPersonaje['clase'].'</h2>
                    <h2> Nivel '.$datosPersonaje['nivel'].'</h2>
                    <a href=Character/chooseCharacter.php?id='.$datosPersonaje['id_personaje'].'>Seleccionar personaje</a>
                </div>';
            }
        }
        echo '</div>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
