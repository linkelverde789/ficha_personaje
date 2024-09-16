<?php
session_start();

function obtenerEquipo()
{
    try {
        include '/var/www/html/connection.php';
        

        $consultas = [
            'armas' => 'SELECT a.id_arma AS id, a.nombre, a.descripcion, a.dano, a.tipo_dano, ia.tipo_equipo 
                        FROM equipo ia 
                        JOIN arma a ON ia.id_arma = a.id_arma 
                        WHERE ia.id_personaje = :id_personaje',
            'armaduras' => 'SELECT a.id_armadura AS id, a.nombre, a.descripcion, a.defensa, a.tipo, a.parte, ia.tipo_equipo 
                            FROM equipo ia 
                            JOIN armadura a ON ia.id_armadura = a.id_armadura 
                            WHERE ia.id_personaje = :id_personaje',
            'escudos' => 'SELECT e.id_escudo AS id, e.nombre, e.descripcion, e.defensa, ie.tipo_equipo 
                          FROM equipo ie 
                          JOIN escudo e ON ie.id_escudo = e.id_escudo 
                          WHERE ie.id_personaje = :id_personaje'
        ];

        foreach ($consultas as $tipo => $consulta) {
            $statement = $con->prepare($consulta);
            $statement->execute([':id_personaje' => $_SESSION['Personaje_ID']]);

            echo "<h3>" . ucfirst($tipo) . "</h3>";
            echo "<table border='0'>";
            echo "<tr>";
            switch ($tipo) {
                case 'armas':
                    echo "<th>Nombre</th><th>Descripción</th><th>Daño</th><th>Tipo Daño</th><th>Acción</th>";
                    break;
                case 'armaduras':
                    echo "<th>Nombre</th><th>Descripción</th><th>Defensa</th><th>Tipo Armadura</th><th>Parte</th><th>Acción</th>";
                    break;
                case 'escudos':
                    echo "<th>Nombre</th><th>Descripción</th><th>Defensa</th><th>Acción</th>";
                    break;
            }
            echo "</tr>";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $campo => $valor) {
                    if ($campo !== 'id' && $campo !== 'tipo_equipo') {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href=\"desequiparObjeto.php?id=" . htmlspecialchars($row['id']) . "&tipo=" . htmlspecialchars($tipo) . "&lugar=" . htmlspecialchars($row['tipo_equipo']) . "\">Desesquipar</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function obtenerEquipoFicha()
{
    try {
        include '/var/www/html/connection.php';


        $consultas = [
            'armas' => 'SELECT a.id_arma AS id, a.nombre, a.descripcion, a.dano, a.tipo_dano, ia.tipo_equipo 
                        FROM equipo ia 
                        JOIN arma a ON ia.id_arma = a.id_arma 
                        WHERE ia.id_personaje = :id_personaje',
            'armaduras' => 'SELECT a.id_armadura AS id, a.nombre, a.descripcion, a.defensa, a.tipo, a.parte, ia.tipo_equipo 
                            FROM equipo ia 
                            JOIN armadura a ON ia.id_armadura = a.id_armadura 
                            WHERE ia.id_personaje = :id_personaje',
            'escudos' => 'SELECT e.id_escudo AS id, e.nombre, e.descripcion, e.defensa, ie.tipo_equipo 
                          FROM equipo ie 
                          JOIN escudo e ON ie.id_escudo = e.id_escudo 
                          WHERE ie.id_personaje = :id_personaje'
        ];

        foreach ($consultas as $tipo => $consulta) {
            $statement = $con->prepare($consulta);
            $statement->execute([':id_personaje' => $_SESSION['Personaje_ID']]);

            echo "<h3>" . ucfirst($tipo) . "</h3>";
            echo "<table border='0'>";
            echo "<tr>";
            switch ($tipo) {
                case 'armas':
                    echo "<th>Nombre</th><th>Descripción</th><th>Daño</th><th>Tipo de Daño</th>";
                    break;
                case 'armaduras':
                    echo "<th>Nombre</th><th>Descripción</th><th>Defensa</th><th>Tipo Armadura</th><th>Parte</th>";
                    break;
                case 'escudos':
                    echo "<th>Nombre</th><th>Descripción</th><th>Defensa</th>";
                    break;
            }
            echo "</tr>";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $campo => $valor) {
                    if ($campo !== 'id' && $campo !== 'tipo_equipo') {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</table><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function obtenerInventario()
{
    try {
        include '/var/www/html/connection.php';


        $consultas = [
            'armas' => 'SELECT a.id_arma AS id, a.nombre, a.peso, a.descripcion, a.dano, a.tipo_dano, ia.cantidad 
                        FROM inventario_arma ia 
                        JOIN arma a ON ia.id_arma = a.id_arma 
                        WHERE ia.id_inventario = :id_inventario',
            'armaduras' => 'SELECT a.id_armadura AS id, a.nombre, a.peso, a.descripcion, a.defensa, a.tipo, a.parte, ia.cantidad 
                            FROM inventario_armadura ia 
                            JOIN armadura a ON ia.id_armadura = a.id_armadura 
                            WHERE ia.id_inventario = :id_inventario',
            'escudos' => 'SELECT e.id_escudo AS id, e.nombre, e.peso, e.descripcion, e.defensa, ie.cantidad 
                          FROM inventario_escudo ie 
                          JOIN escudo e ON ie.id_escudo = e.id_escudo 
                          WHERE ie.id_inventario = :id_inventario',
            'objetos normales' => 'SELECT o.id_objeto_normal AS id, o.nombre, o.peso, o.descripcion, ion.cantidad 
                                   FROM inventario_objeto_normal ion 
                                   JOIN objeto_normal o ON ion.id_objeto_normal = o.id_objeto_normal 
                                   WHERE ion.id_inventario = :id_inventario'
        ];

        foreach ($consultas as $tipo => $consulta) {
            $statement = $con->prepare($consulta);
            $statement->execute([':id_inventario' => $_SESSION['Personaje_ID']]);

            echo "<h3>" . ucfirst($tipo) . "</h3>";
            echo "<table border='1'>";
            echo "<tr>";
            switch ($tipo) {
                case 'armas':
                    echo "<th>Nombre</th><th>Peso</th><th>Descripción</th><th>Daño</th><th>Tipo Daño</th><th>Cantidad</th><th>Acción</th>";
                    break;
                case 'armaduras':
                    echo "<th>Nombre</th><th>Peso</th><th>Descripción</th><th>Defensa</th><th>Tipo Armadura</th><th>Parte</th><th>Cantidad</th><th>Acción</th>";
                    break;
                case 'escudos':
                    echo "<th>Nombre</th><th>Peso</th><th>Descripción</th><th>Defensa</th><th>Cantidad</th><th>Acción</th>";
                    break;
                case 'objetos normales':
                    echo "<th>Nombre</th><th>Peso</th><th>Descripción</th><th>Cantidad</th><th>Acción</th>";
                    break;
            }
            echo "</tr>";

            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                foreach ($row as $campo => $valor) {
                    if ($campo !== 'id') {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                }
                echo "<td>";
                echo "<a href='#' onclick='eliminarObjeto(" . htmlspecialchars($row['id']) . ", " . htmlspecialchars($row['cantidad']) . ", \"" . htmlspecialchars($tipo) . "\")'>Eliminar</a>";

                if ($tipo !== 'objetos normales') {
                    if ($tipo == 'armas') {
                        echo " | <a href='#' onclick='equiparArma(" . htmlspecialchars($row['id']) . ")'>Equipar</a>";
                    } else {
                        echo " | <a href='equiparObjeto.php?id=" . htmlspecialchars($row['id']) . "&tipo=" . htmlspecialchars($tipo) . "'>Equipar</a>";
                    }
                }
                echo "</td>";
                echo "</tr>";
            }

            echo "</table><br>";
        }

        echo "<script>
        function equiparArma(id) {
            const decision = confirm('¿Quieres equipar esta arma como primaria? Si cancelas, se equipará como secundaria.');
            if (decision) {
                window.location.href = 'equiparObjeto.php?id=' + id + '&tipo=armas&lugar=Arma';
            } else {
                window.location.href = 'equiparObjeto.php?id=' + id + '&tipo=armas&lugar=Arma Secundaria';
            }
        }

function eliminarObjeto(id, cantidad, tipo) {
    let url = 'eliminarObjeto.php?id=' + id + '&tipo=' + tipo;
    let cantidadAEliminar = 1;  // Valor por defecto

    if (cantidad > 1) {
        cantidadAEliminar = prompt('Este objeto tiene una cantidad de ' + cantidad + '. ¿Cuántos deseas eliminar?', 1);
        if (cantidadAEliminar != null && cantidadAEliminar > 0 && cantidadAEliminar <= cantidad) {
            url += '&cantidad=' + cantidadAEliminar;
        } else {
            alert('Cantidad inválida. No se realizará ninguna acción.');
            return;
        }
    } else {
        url += '&cantidad=' + cantidadAEliminar;
    }

    if (confirm('¿Estás seguro de que quieres eliminar este objeto?')) {
        window.location.href = url;
    }
}

        </script>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function peso()
{
    include '/var/www/html/connection.php';

    $consulta = 'select peso_total, capacidad from personajes where id_personaje=:id_personaje';
    $statement = $con->prepare($consulta);
    $statement->execute([':id_personaje' => $_SESSION['Personaje_ID']]);
    $row = $statement->fetch
    (PDO::FETCH_ASSOC);
    echo $row['peso_total'] . '/' . $row['capacidad'];
}

try {
    include '/var/www/html/connection.php';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $tipo = $_POST['type'];
        $consulta = 'INSERT INTO ' . $tipo . ' (nombre, peso, descripcion';
        $segundaConsulta = 'INSERT INTO inventario_' . $tipo . ' (id_inventario, id_' . $tipo . ', cantidad) VALUES (:id_inventario, :id_' . $tipo . ', :cantidad)';

        $name = $_POST['nombre'];
        $peso = $_POST['peso'];
        $descripcion = $_POST['description'];
        $cantidad = $_POST['cantidad'];

        switch ($tipo) {
            case 'arma':
                $dano = $_POST['cantidadDados'] . $_POST['dice'];
                $tipoDano = $_POST['tipo_dano'];
                $consulta .= ', dano, tipo_dano) VALUES (:nombre, :peso, :descripcion, :dano, :tipo_dano);';
                $statement = $con->prepare($consulta);
                $statement->execute([
                    ':nombre' => $name,
                    ':peso' => $peso,
                    ':descripcion' => $descripcion,
                    ':dano' => $dano,
                    ':tipo_dano' => $tipoDano
                ]);
                $id_arma = $con->lastInsertId();
                $inventario = $con->prepare($segundaConsulta);
                $inventario->execute([
                    ':id_inventario' => $_SESSION['Personaje_ID'],
                    ':id_arma' => $id_arma,
                    ':cantidad' => $cantidad
                ]);
                break;

            case 'escudo':
                $defensa = $_POST['defensa'];
                $consulta .= ', defensa) VALUES (:nombre, :peso, :descripcion, :defensa);';
                $statement = $con->prepare($consulta);
                $statement->execute([
                    ':nombre' => $name,
                    ':peso' => $peso,
                    ':descripcion' => $descripcion,
                    ':defensa' => $defensa
                ]);
                $id_escudo = $con->lastInsertId();
                $inventario = $con->prepare($segundaConsulta);
                $inventario->execute([
                    ':id_inventario' => $_SESSION['Personaje_ID'],
                    ':id_escudo' => $id_escudo,
                    ':cantidad' => $cantidad
                ]);
                break;
            case 'armadura':
                $defensa = $_POST['defensa'];
                $tipoArmadura = $_POST['tipo_armadura'];
                $parte = $_POST['parte'];
                $consulta .= ', defensa, tipo, parte) VALUES (:nombre, :peso, :descripcion, :defensa, :tipo, :parte);';
                $statement = $con->prepare($consulta);
                $statement->execute([
                    ':nombre' => $name,
                    ':peso' => $peso,
                    ':descripcion' => $descripcion,
                    ':defensa' => $defensa,
                    ':tipo' => $tipoArmadura,
                    ':parte' => $parte
                ]);
                $id_armadura = $con->lastInsertId();
                $inventario = $con->prepare($segundaConsulta);
                $inventario->execute([
                    ':id_inventario' => $_SESSION['Personaje_ID'],
                    ':id_armadura' => $id_armadura,
                    ':cantidad' => $cantidad
                ]);
                break;

            case 'objeto_normal':
                $consulta .= ') VALUES (:nombre, :peso, :descripcion);';
                $statement = $con->prepare($consulta);
                $statement->execute([
                    ':nombre' => $name,
                    ':peso' => $peso,
                    ':descripcion' => $descripcion
                ]);

                $id_objeto_normal = $con->lastInsertId();

                $inventario = $con->prepare($segundaConsulta);
                $inventario->execute([
                    ':id_inventario' => $_SESSION['Personaje_ID'],
                    ':id_objeto_normal' => $id_objeto_normal,
                    ':cantidad' => $cantidad
                ]);
                break;
        }
        header('Location: inventario.php');
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


?>