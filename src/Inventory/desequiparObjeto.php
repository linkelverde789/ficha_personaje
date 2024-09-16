<?php
if (isset($_GET['id']) && isset($_GET['tipo']) && isset($_GET['lugar'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
    $lugar = $_GET['lugar'];

    try {
        include '/var/www/html/connection.php';

        switch ($tipo) {
            case 'armas':
                $consulta = 'delete from equipo where id_arma=:id and tipo_equipo=:lugar';
                break;
            case 'armaduras':
                $consulta = 'delete from equipo where id_armadura=:id  and tipo_equipo=:lugar';
                break;
            case 'escudos':
                $consulta = 'delete from equipo where id_escudo=:id and tipo_equipo=:lugar';
                break;
            default:
                die('Tipo de objeto no válido');
        }
        $statement = $con->prepare($consulta);
        $statement->execute([':id' => $id, ':lugar' => $lugar]);


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    header('Location: inventario.php');
    exit();

}
?>