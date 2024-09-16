<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partida de Rol - Lanzar Dados</title>
    <link rel="stylesheet" href="styles/normalize.css">
    <link rel="stylesheet" href="styles/dice.css">
</head>

<body>
    <nav>
        <ul class="nav-links">
            <li><a href="../home.php" class="button">Inicio</a></li>
            <?php
            if(isset($_SESSION['Personaje_ID'])){
                include 'Character/getCharacterElement.php';
               echo '<li><a href="../Inventory/inventario.php" class="button">Gestionar inventario</a></li>';
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
             echo '<li><a href="../Character/updateCharacter.php" class="button">Actualizar Personaje</a></li>';
             echo '<li><a href="../CharacterSheet/ficha.php" class="button">Ficha</a></li>';
            }else{
                echo '<li><a href="../Character/createCharacter.php" class="button">Crear Personaje</a></li>';
            }
            ?>
            
        </ul>
    </nav>

    <h1>Lanzador de Dados</h1>
    <section class="dados">
        <div id="d20">
            <p id="20">D20: --</p>
            <button id="boton_d20">Lanzar D20</button>
        </div>
        <div id="d16">
            <p id="16">D16: --</p>
            <button id="boton_d16">Lanzar D16</button>
        </div>
        <div id="d12">
            <p id="12">D12: --</p>
            <button id="boton_d12">Lanzar D12</button>
        </div>
        <div id="d10">
            <p id="10">D10: --</p>
            <button id="boton_d10">Lanzar D10</button>
        </div>
        <div id="d8">
            <p id="8">D8: --</p>
            <button id="boton_d8">Lanzar D8</button>
        </div>
        <div id="d6">
            <p id="6">D6: --</p>
            <button id="boton_d6">Lanzar D6</button>
        </div>
        <div id="d4">
            <p id="4">D4: --</p>
            <button id="boton_d4">Lanzar D4</button>
        </div>
    </section>

    <script src="javascript/rollDice.js">
    </script>
</body>

</html>