<?php
if (isset($_GET['id']) && isset($_GET['tipo']) && isset($_GET['cantidad'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
    $cantidadEliminar = $_GET['cantidad'];

    try {
        include '/var/www/html/connection.php';


        switch ($tipo) {
            case 'armas':
                $statement = $con->prepare("SELECT cantidad FROM inventario_arma WHERE id_arma = :id");
                $statement->execute([':id' => $id]);
                $resultado = $statement->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $cantidad = $resultado['cantidad'];
                    $nuevaCantidad = $cantidad - $cantidadEliminar;

                    if ($nuevaCantidad < 1) {
                        $consulta = 'DELETE FROM inventario_arma WHERE id_arma = :id';
                    } else {
                        $consulta = 'UPDATE inventario_arma SET cantidad = :nuevaCantidad WHERE id_arma = :id';
                        $params = [':nuevaCantidad' => $nuevaCantidad, ':id' => $id];
                    }
                } else {
                    die('Arma no encontrada en el inventario');
                }
                break;

            case 'armaduras':
                $statement = $con->prepare("SELECT cantidad FROM inventario_armadura WHERE id_armadura = :id");
                $statement->execute([':id' => $id]);
                $resultado = $statement->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $cantidad = $resultado['cantidad'];
                    $nuevaCantidad = $cantidad - $cantidadEliminar;

                    if ($nuevaCantidad < 1) {
                        $consulta = 'DELETE FROM inventario_armadura WHERE id_armadura = :id';
                    } else {
                        $consulta = 'UPDATE inventario_armadura SET cantidad = :nuevaCantidad WHERE id_armadura = :id';
                        $params = [':nuevaCantidad' => $nuevaCantidad, ':id' => $id];
                    }
                } else {
                    die('Armadura no encontrada en el inventario');
                }
                break;

            case 'escudos':
                $statement = $con->prepare("SELECT cantidad FROM inventario_escudo WHERE id_escudo = :id");
                $statement->execute([':id' => $id]);
                $resultado = $statement->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $cantidad = $resultado['cantidad'];
                    $nuevaCantidad = $cantidad - $cantidadEliminar;

                    if ($nuevaCantidad < 1) {
                        $consulta = 'DELETE FROM inventario_escudo WHERE id_escudo = :id';
                        $segundaConsulta = 'DELETE FROM escudo WHERE id_escudo = :id';
                    } else {
                        $consulta = 'UPDATE inventario_escudo SET cantidad = :nuevaCantidad WHERE id_escudo = :id';
                        $params = [':nuevaCantidad' => $nuevaCantidad, ':id' => $id];
                    }
                } else {
                    die('Escudo no encontrado en el inventario');
                }
                break;

            case 'objetos normales':
                $statement = $con->prepare("SELECT cantidad FROM inventario_objeto_normal WHERE id_objeto_normal = :id");
                $statement->execute([':id' => $id]);
                $resultado = $statement->fetch(PDO::FETCH_ASSOC);

                if ($resultado) {
                    $cantidad = $resultado['cantidad'];
                    $nuevaCantidad = $cantidad - $cantidadEliminar;

                    if ($nuevaCantidad < 1) {
                        $consulta = 'DELETE FROM inventario_objeto_normal WHERE id_objeto_normal = :id';
                    } else {
                        $consulta = 'UPDATE inventario_objeto_normal SET cantidad = :nuevaCantidad WHERE id_objeto_normal = :id';
                        $params = [':nuevaCantidad' => $nuevaCantidad, ':id' => $id];
                    }
                } else {
                    die('Objeto normal no encontrado en el inventario');
                }
                break;

            default:
                die('Tipo de objeto no válido');
        }

        $statement = $con->prepare($consulta);
        $statement->execute($params ?? [':id' => $id]);

        if (isset($segundaConsulta)) {
            $secondStatement = $con->prepare($segundaConsulta);
            $secondStatement->execute([':id' => $id]);
        }

        header('Location: inventario.php');
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "ID, tipo de objeto o cantidad no proporcionado.";
}
?>