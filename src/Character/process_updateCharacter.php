<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $level;
    $exp = $_POST['exp'];
    $HP = $_POST['HP'];
    $gold = $_POST['gold'];
    $languages = $_POST['languages'];
    $ideals = $_POST['ideals'];
    $bonds = $_POST['bonds'];
    $flaws = $_POST['flaws'];
    $background = $_POST['background'];
    $Fuerza = $_POST['Fuerza_base_hidden'];
    $Destreza = $_POST['Destreza_base_hidden'];
    $Constitución = $_POST['Constitución_base_hidden'];
    $Inteligencia = $_POST['Inteligencia_base_hidden'];
    $Sabiduría = $_POST['Sabiduría_base_hidden'];
    $Carisma = $_POST['Carisma_base_hidden'];

    if ($exp < 300) {
        $level = 1;
    } else if ($exp < 900) {
        $level = 2;
    } else if ($exp < 2700) {
        $level = 3;
    } else if ($exp < 6500) {
        $level = 4;
    } else if ($exp < 14000) {
        $level = 5;
    } else if ($exp < 23000) {
        $level = 6;
    } else if ($exp < 34000) {
        $level = 7;
    } else if ($exp < 48000) {
        $level = 8;
    } else if ($exp < 64000) {
        $level = 9;
    } else if ($exp < 85000) {
        $level = 10;
    } else if ($exp < 100000) {
        $level = 11;
    } else if ($exp < 120000) {
        $level = 12;
    } else if ($exp < 140000) {
        $level = 13;
    } else if ($exp < 165000) {
        $level = 14;
    } else if ($exp < 195000) {
        $level = 15;
    } else if ($exp < 225000) {
        $level = 16;
    } else if ($exp < 265000) {
        $level = 17;
    } else if ($exp < 305000) {
        $level = 18;
    } else if ($exp < 355000) {
        $level = 19;
    } else {
        $level = 20;
    }

    try {
        include '/var/www/html/connection.php';

        $consulta = 'UPDATE personajes SET 
            oro = :oro, 
            experiencia = :experiencia, 
            idiomas = :idiomas, 
            personalidad = :personalidad, 
            ideales = :ideales, 
            defectos = :defectos, 
            lazos = :lazos, 
            fuerza = :fuerza, 
            destreza = :destreza, 
            constitucion = :constitucion, 
            inteligencia = :inteligencia, 
            sabiduria = :sabiduria, 
            carisma = :carisma,
            nivel = :nivel 
            WHERE id_personaje = :id_personaje';

        $statement = $con->prepare($consulta);

        $statement->execute([
            ':oro' => $gold,
            ':experiencia' => $exp,
            ':idiomas' => $languages,
            ':personalidad' => $background,
            ':ideales' => $ideals,
            ':defectos' => $flaws,
            ':lazos' => $bonds,
            ':fuerza' => $Fuerza,
            ':destreza' => $Destreza,
            ':constitucion' => $Constitución,
            ':inteligencia' => $Inteligencia,
            ':sabiduria' => $Sabiduría,
            ':carisma' => $Carisma,
            ':nivel' => $level,
            ':id_personaje' => $_SESSION['Personaje_ID']
        ]);
        
        header('Location: ../CharacterSheet/ficha.php');
        exit();
        
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
