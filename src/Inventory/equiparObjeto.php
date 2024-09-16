<?php
session_start();
if (isset($_GET['id']) && isset($_GET['tipo'])) {
    $id = $_GET['id'];
    $tipo = $_GET['tipo'];
    $lugar='';
    try {
        include '/var/www/html/connection.php';

        switch ($tipo) {
            case 'armas':
                $lugar=$_GET['lugar'];
                $consulta = 'insert into equipo (id_personaje,id_arma, tipo_equipo) values (:personaje,:id, :lugar)';
                break;
            case 'armaduras':
                $posicion=$con->prepare('select parte from armadura where id_armadura=:id');
                $posicion->execute([':id'=>$id]);
                $resultado=$posicion->fetch(PDO::FETCH_ASSOC);
                $lugar=$resultado['parte'];
                $consulta = 'insert into equipo (id_personaje,id_armadura, tipo_equipo) values (:personaje,:id, :lugar)';
                break;
            case 'escudos':
                $lugar='Escudo';
                $consulta = 'insert into equipo (id_personaje,id_escudo, tipo_equipo) values (:personaje,:id, :lugar)';
                break;
            default:
                die('Tipo de objeto no válido');
        }
        $statement = $con->prepare($consulta);
        $statement->execute([':personaje'=>$_SESSION['Personaje_ID'],':id' => $id, ':lugar' => $lugar]);


    }catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    header('Location: inventario.php');
    exit();
}
?>