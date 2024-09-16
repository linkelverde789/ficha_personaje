<?php
session_start();
function lista()
{
    try {
        include '/var/www/html/connection.php';

        if (!isset($_SESSION['Personaje_ID'])) {
            echo "Error: No hay personaje seleccionado.";
            return;
        }
        $statement = $con->prepare('SELECT nivel, clase FROM personajes WHERE id_personaje = :id_personaje');
        $statement->execute([':id_personaje' => $_SESSION['Personaje_ID']]);
        $character = $statement->fetch(PDO::FETCH_ASSOC);
        if ($character['clase'] == 'Brujo') {
            if ($character['nivel'] < 11) {
                $select = $con->prepare('select h.* from hechizos h inner join clases_hechizos ch on (h.id=ch.hechizo_id)
                where ch.clase=:clase and h.nivel<=(select nivel_maximo_hechizo from ranurasbrujos where nivel=:nivel and arcanum=false) and h.id not in (select id_hechizo from hechizos_personajes where id_personaje=:id_personaje)
                    order by h.nivel, h.nombre;');
                $select->execute([
                    ':nivel' => $character['nivel'],
                    ':clase' => 'Brujo',
                    ':id_personaje' => $_SESSION['Personaje_ID']
                ]);
            } else {
                $select = $con->prepare('select h.* from hechizos h inner join clases_hechizos ch on (h.id=ch.hechizo_id)
                where ch.clase=:clase and h.nivel<=(select nivel_maximo_hechizo from ranurasbrujos where nivel=:nivel and arcanum=true) and h.id not in (select id_hechizo from hechizos_personajes where id_personaje=:id_personaje)
                    order by h.nivel, h.nombre;');
                $select->execute([
                    ':nivel' => $character['nivel'],
                    ':clase' => 'Brujo',
                    ':id_personaje' => $_SESSION['Personaje_ID']
                ]);
            }
        } else {
            $select = $con->prepare(
                'SELECT h.id, h.nombre, h.nivel, h.descripcion, h.daño, h.distancia, h.tiempo_carga, h.duracion, h.componentes
FROM hechizos h
JOIN clases_hechizos ch ON h.id = ch.hechizo_id
JOIN RanurasPorClaseYNivel r ON ch.nivel_aprendido = r.nivel_hechizo
LEFT JOIN hechizos_personajes hp ON h.id = hp.id_hechizo AND hp.id_personaje = :id_personaje
WHERE ch.clase = :clase
  AND r.clase = :clase
  AND r.nivel = :nivel
  AND hp.id_hechizo IS NULL
order by nivel, nombre
'
            );
            $select->execute([
                ':nivel' => $character['nivel'],
                ':clase' => $character['clase'],
                ':id_personaje' => $_SESSION['Personaje_ID']
            ]);
        }
        $lista = $select->fetchAll(PDO::FETCH_ASSOC);
        if (sizeof($lista) !== 0) {
            echo "<select name='hechizos' id='hechizos' onchange='mostrarDescripcion()'>";
            echo '<option value="none" disabled selected>Elige un hechizo para añadirlo.</option>';
            foreach ($lista as $item) {
                echo '<option value="' . $item['id'] . '">' . htmlspecialchars($item['nombre'], ENT_QUOTES, 'UTF-8') . '</option>';
            }
            echo "</select>";
            foreach ($lista as $item) {
                if ($item['nivel'] == 0) {
                    echo '<p id="' . $item['id'] . '" style="display: none;"> <b>Truco. </b>' . htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8') . '</p>';
                } else {
                    echo '<p id="' . $item['id'] . '" style="display: none;"> <b>Nivel: ' . htmlspecialchars($item['nivel']) . '. </b>' . htmlspecialchars($item['descripcion'], ENT_QUOTES, 'UTF-8') . '</p>';
                }
            }
            echo "<button type='submit'>Aprender Hechizo</button>";
        } else {
            echo "<h2>No puedes aprender hechizos</h2>";
        }
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        return null;
    }
}
function getLearnedSpells()
{
    try {
        include '/var/www/html/connection.php';

        if (!isset($_SESSION['Personaje_ID'])) {
            echo "Error: No hay personaje seleccionado.";
            return;
        }
        $statement = $con->prepare('SELECT * FROM info_hechizos WHERE id_personaje = :id_personaje ORDER BY nivel');
        $statement->execute([
            ':id_personaje' => $_SESSION['Personaje_ID']
        ]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            echo "Este personaje no tiene hechizos aprendidos.";
            return;
        }
        echo '<table>';
        echo '<thead>
            <tr>
                <th>Nivel</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Alcance</th>
                <th>Tiempo de carga</th>
                <th>Duración</th>
                <th>Componentes</th>
                <th>Acciones</th>
            </tr>
        </thead>';
        echo '<tbody>';
        foreach ($result as $item) {
            echo '<tr>';
            if ($item['nivel'] == 0) {
                echo '<td>Truco </td>';
            } else {
                echo '<td>' . htmlspecialchars($item['nivel']) . '</td>';
            }
            echo '<td>' . htmlspecialchars($item['nombre']) . '</td>
                <td>' . htmlspecialchars($item['tipo']) . '</td>
                <td>' . htmlspecialchars($item['descripcion']) . '</td>
                <td>' . htmlspecialchars($item['distancia']) . '</td>
                <td>' . htmlspecialchars($item['tiempo_carga']) . '</td>
                <td>' . htmlspecialchars($item['duracion']) . '</td>
                <td>' . htmlspecialchars($item['componentes']) . '</td>
                <td>
                    <form id="botonEiminar" method="POST" action="deleteSpell.php" style="display:inline;">
                        <input type="hidden" name="id_hechizo" value="' . htmlspecialchars($item['id']) . '">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        return null;
    }
}
function getSpellsSlots()
{
    try {
        include '/var/www/html/connection.php';

        if (!isset($_SESSION['Personaje_ID'])) {
            echo "Error: No hay personaje seleccionado.";
            return;
        }
        $statement = $con->prepare('select clase, nivel from personajes where id_personaje=:id_personaje');
        $statement->execute([':id_personaje' => $_SESSION['Personaje_ID']]);
        $elements = $statement->fetch(PDO::FETCH_ASSOC);
        if ($elements['clase'] == 'Brujo') {
            $statement = $con->prepare('select * from ranurasbrujos where nivel=:nivel ');
            $statement->execute([':nivel' => $elements['nivel']]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            echo '<table>';
            echo '<thead>
                <tr>
                    <th>Nivel de ranuras</th>
                    <th>Número de ranuras</th>
                </tr>
            </thead>';
            echo '<tbody>';
            foreach ($result as $item) {
                echo '<tr>
    <td>' . $item['nivel_maximo_hechizo'] . '</td>
    <td>' . $item['cantidad_ranuras'] . '</td>
    
    </tr>';
            }
        } else {
            $statement = $con->prepare('SELECT 
    r.nivel_hechizo, 
    r.cantidad_ranuras, 
    (r.cantidad_ranuras - COUNT(h.nombre)) AS ranuras_restantes
FROM 
    ranurasporclaseynivel r
LEFT JOIN 
    info_hechizos h 
    ON r.nivel_hechizo = h.nivel AND h.id_personaje = :id_personaje
WHERE 
    r.clase = :clase 
    AND r.nivel = :nivel
GROUP BY 
    r.nivel_hechizo, 
    r.cantidad_ranuras;
');
            $statement->execute([':id_personaje' => $_SESSION['Personaje_ID'], ':clase' => $elements['clase'], ':nivel' => $elements['nivel']]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            echo '<table>';
            echo '<thead>
                <tr>
                    <th>Nivel</th>
                    <th>Número de ranuras</th>
                    <th>Ranuras restantes</th>
                </tr>
            </thead>';
            echo '<tbody>';
            foreach ($result as $item) {
                if ($item['nivel_hechizo'] == 0) {
                    echo '<tr>
                    <td>Truco </td>';
                } else {
                    echo '<tr>
                    <td>' . $item['nivel_hechizo'] . '</td>';
                }
                echo '<td>' . htmlspecialchars($item['cantidad_ranuras']) . '</td>
                    <td>' . htmlspecialchars($item['ranuras_restantes']) . '</td>
                </tr>';
            }
        }
        echo '</tbody>';
        echo '</table>';
    } catch (PDOException $e) {
        echo "Error en la base de datos: " . $e->getMessage();
        return null;
    }
}
function learnSpell($personaje_id)
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $spell_id = $_POST['id'];
        try {
            include '/var/www/html/connection.php';

            $statement = $con->prepare('insert into hechizos_personajes (id_personaje, id_hechizo) values (:id_personaje, :id_hechizo)');
            $statement->execute([
                ':id_personaje' => $personaje_id,
                ':id_hechizo' => $spell_id
            ]);
            header('Location: hechizos.php');
            exit();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage();
            return null;
        }
    }
}
?>