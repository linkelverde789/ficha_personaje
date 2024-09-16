<?php
session_start();
if (!isset($_SESSION['Personaje_ID'])) {
    header('Location: ../home.php');
}
include '../security.php';
include '../objetos.php';
include '../Character/getCharacterElement.php';

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/createCharacter.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        nav {
            background-color: #333;
            padding: 10px;
            width: -webkit-fill-available;
            font-size: medium;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .nav-links {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #555;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #777;
        }

        body {
            padding: 100px;
            padding-top: 0;
        }

        .pepe {
            border-radius: 0px 0px;
        }

        form input, select {
            font-family: 'Roboto';
        }
    </style>

</head>

<body>
    <nav>
        <ul class="nav-links">
            <li><a href="../home.php" class="button">Inicio</a></li>
            <?php
            if (
                $character['clase'] == 'Brujo' ||
                $character['clase'] == 'Hechicero' ||
                $character['clase'] == 'Explorador' ||
                $character['clase'] == 'Mago' ||
                $character['clase'] == 'Paladín' ||
                $character['clase'] == 'Druida' ||
                $character['clase'] == 'Clérigo' ||
                $character['clase'] == 'Bardo'
            ) {
                echo '<li><a href="../Spells/hechizos.php" class="button">Gestionar hechizos</a></li>';
            }
            ?>
            <li><a href="../Character/updateCharacter.php" class="button">Editar personaje</a></li>
            <li><a href="../CharacterSheet/ficha.php" class="button">Ficha</a></li>
            <li><a href="../dice.php" class="button">Lanzar dados</a></li>
        </ul>
    </nav>

    <div class="pepe">

        <h1 style="border: 0;">Gestión de Inventario</h1>
        <h2>Añadir Objeto al Inventario</h2>

        <select name="choseObject" id="choseObject" onchange="showForm()" required>
            <option value="none" disabled selected>Elige un tipo de objeto para añadir al inventario</option>
            <option value="arma">Arma</option>
            <option value="armadura">Armadura</option>
            <option value="escudo">Escudo</option>
            <option value="otros">Otros</option>
        </select>

<form name="weapon" id="weapon" method="post" style="display:none;">
    <input type="hidden" value="arma" name="type" required>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre del arma" required>
    <input type="number" name="cantidad" id="cantidad" min="1" max="99" placeholder="Cantidad" required>
    <select name="dice" id="dice" required>
        <option value="none" disabled selected>Elige el dado del daño</option>
        <option value="d4">d4</option>
        <option value="d6">d6</option>
        <option value="d8">d8</option>
        <option value="d10">d10</option>
        <option value="d12">d12</option>
        <option value="d16">d16</option>
        <option value="d20">d20</option>
    </select>
    <input type="number" name="cantidadDados" id="cantidadDados" min="1" max="99" placeholder="Número de dados" required>
    <select id="tipo_dano" name="tipo_dano" required>
        <option value="none" disabled selected>Elige el tipo de daño</option>
        <option value="Cortante">Cortante</option>
        <option value="Perforante">Perforante</option>
        <option value="Contundente">Contundente</option>
        <option value="Fuego">Fuego</option>
        <option value="Frío">Frío</option>
        <option value="Ácido">Ácido</option>
        <option value="Eléctrico">Eléctrico</option>
        <option value="Veneno">Veneno</option>
        <option value="Psíquico">Psíquico</option>
        <option value="Radiante">Radiante</option>
        <option value="Necrótico">Necrótico</option>
    </select>
    <input type="text" name="description" id="description" placeholder="Descripción" required>
    <input type="number" name="peso" id="peso" min="1" placeholder="Peso" required>
    <button type="submit">Añadir Arma</button>
</form>

<form name="shield" id="shield" method="post" style="display:none;">
    <input type="hidden" value="escudo" name="type" required>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre del escudo" required>
    <input type="number" name="cantidad" id="cantidad" min="1" max="99" placeholder="Cantidad" required>
    <input type="number" name="defensa" id="defensa" min="1" placeholder="Defensa" required>
    <input type="text" name="description" id="description" placeholder="Descripción" required>
    <input type="number" name="peso" id="peso" min="1" placeholder="Peso" required>
    <button type="submit">Añadir Escudo</button>
</form>

<form name="armor" id="armor" method="post" style="display:none;">
    <input type="hidden" value="armadura" name="type" required>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre de la armadura" required>
    <input type="number" name="cantidad" id="cantidad" min="1" max="99" placeholder="Cantidad" required>
    <input type="number" name="defensa" id="defensa" min="1" placeholder="Defensa" required>
    <select id="tipo_armadura" name="tipo_armadura" required>
        <option value="none" disabled selected>Elige el tipo de armadura</option>
        <option value="Ligera">Ligera</option>
        <option value="Media">Media</option>
        <option value="Pesada">Pesada</option>
    </select>
    <select id="parte" name="parte" required>
        <option value="none" disabled selected>Elige la posición de la armadura</option>
        <option value="Cabeza">Cabeza</option>
        <option value="Pechera">Pechera</option>
        <option value="Piernas">Piernas</option>
    </select>
    <input type="text" name="description" id="description" placeholder="Descripción" required>
    <input type="number" name="peso" id="peso" min="1" placeholder="Peso" required>
    <button type="submit">Añadir Armadura</button>
</form>

<form name="other" id="other" method="post" style="display:none;">
    <input type="hidden" value="objeto_normal" name="type" required>
    <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
    <input type="number" name="cantidad" id="cantidad" min="1" max="99" placeholder="Cantidad" required>
    <input type="text" name="description" id="description" placeholder="Descripción" required>
    <input type="number" name="peso" id="peso" min="1" placeholder="Peso" required>
    <button type="submit">Añadir objeto</button>
</form>

        <div class="inventory-container">
            <div class="section">
                <h2>Tu inventario</h2>
                <h3>Peso: <span style="float: right;"><?php peso(); ?></span></h3>
                <br>
                <?php obtenerInventario(); ?>
            </div>

            <div class="section">
                <h2>Tu equipo</h2>
                <?php obtenerEquipo(); ?>
            </div>
        </div>


    </div>

    <script src="../javascript/showObjectForm.js"></script>
    <script src="../javascript/checkObject.js"></script>
</body>

</html>