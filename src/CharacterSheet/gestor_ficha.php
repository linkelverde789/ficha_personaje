<?php
session_start();
        include '/var/www/html/connection.php';

$statement = $con->prepare('select * from ficha where id_personaje=:id_personaje');
$statement->execute([
    'id_personaje' => $_SESSION['Personaje_ID']
]);
$character = $statement->fetch(PDO::FETCH_ASSOC);

function clase_armadura($destreza)
{
    try {
        include '/var/www/html/connection.php';

        $statement = $con->prepare(
            'SELECT vista_defensa_total.defensa_total, personajes.destreza 
             FROM vista_defensa_total 
             INNER JOIN personajes ON vista_defensa_total.id_personaje = personajes.id_personaje
             WHERE personajes.id_personaje = :id_personaje'
        );
        $statement->execute([
            'id_personaje' => $_SESSION['Personaje_ID']
        ]);
        $character = $statement->fetch(PDO::FETCH_ASSOC);
        if ($character) {
            return floor(($character['destreza'] - 10) / 2) + $character['defensa_total'];
        } else {
            return floor(($destreza - 10) / 2) + 10;
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        return null;
    }
}

function obtenerNombre(){
    try {
        include '/var/www/html/connection.php';

        $statement = $con->prepare('select username from usuarios where id_usuario=:id_usuario');
        $statement->execute([
            ':id_usuario' => $_SESSION['id']
        ]);
        $character = $statement->fetch(PDO::FETCH_ASSOC);
        return $character['username'];
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        return null;
    }
}

function obtenerHechizosSimple(){
    try {
        include '/var/www/html/connection.php';

        $statement = $con->prepare('SELECT * FROM info_hechizos WHERE id_personaje = :id_personaje');
        $statement->execute([
            ':id_personaje' => $_SESSION['Personaje_ID']
        ]);
        $spells = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo "<table>";
        echo "<thead style='text-align: justify';> <th>Nivel</th><th>Nombre</th></thead>";
        echo "<tbody>";
        foreach ($spells as $item) {
            echo "<tr>";
            if ($item['nivel'] == 0) {
                echo "<td>Truco</td>";
            } else {
                echo "<td>" . htmlspecialchars($item['nivel']) . "</td>";
            }
            echo "<td>" . htmlspecialchars($item['nombre']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . htmlspecialchars($e->getMessage());
        return null;
    }
}


?>