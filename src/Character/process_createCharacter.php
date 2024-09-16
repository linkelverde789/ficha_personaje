<?php

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $raza = $_POST['raza'];
    $clase = $_POST['clase'];
    $transfondo = $_POST['transfondo'];
    $Fuerza = $_POST['Fuerza_base_hidden'];
    $Destreza = $_POST['Destreza_base_hidden'];
    $Constitución = $_POST['Constitución_base_hidden'];
    $Inteligencia = $_POST['Inteligencia_base_hidden'];
    $Sabiduría = $_POST['Sabiduría_base_hidden'];
    $Carisma = $_POST['Carisma_base_hidden'];
    $HP = $_POST['HP_hidden'];
    $historia = $_POST['historia'];
    $alineamiento = $_POST['alineamiento'];
    $idiomas=$_POST['languages'];
    $lazos=$_POST['bonds'];
    $ideales=$_POST['ideals'];
    $defectos=$_POST['flaws'];
    $personalidad=$_POST['personality'];

    try {
        include '/var/www/html/connection.php';


        $statement = $con->prepare('INSERT INTO personajes (nombre, clase, raza, fuerza, destreza, constitucion,
        inteligencia, sabiduria, carisma, historia_personaje, alineamiento, transfondo, HP, idiomas, lazos, ideales, defectos, personalidad)
            VALUES (:name, :clase, :raza, :fuerza, :destreza, :constitucion, :inteligencia, :sabiduria, :carisma, :historia_personaje, :alineamiento, :transfondo, :HP
            , :idiomas, :lazos, :ideales, :defectos, :personalidad)
            RETURNING id_personaje');

        $statement->execute([
            ':name' => $name,
            ':raza' => $raza,
            ':clase' => $clase,
            ':fuerza' => $Fuerza,
            ':destreza' => $Destreza,
            ':constitucion' => $Constitución,
            ':inteligencia' => $Inteligencia,
            ':sabiduria' => $Sabiduría,
            ':carisma' => $Carisma,
            ':historia_personaje' => $historia,
            ':alineamiento' => $alineamiento,
            ':transfondo' => $transfondo,
            ':HP' => $HP,
            ':idiomas' => $idiomas,
            ':lazos' => $lazos,
            ':ideales' => $ideales,
            ':defectos' => $defectos,
            ':personalidad' => $personalidad
        ]);
        $id_personaje = $statement->fetchColumn();

        $user_character = $con->prepare('INSERT INTO usuarios_personajes (id_personaje, id_usuario) VALUES (:id_personaje, :id_usuario)');
        $user_character->execute([
            ':id_personaje' => $id_personaje,
            ':id_usuario' => $_SESSION['id']
        ]);

        $_SESSION['Personaje_ID'] = $id_personaje;

        header('Location: ../Inventory/inventario.php');
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
