<?php
include '../security.php';

include 'getCharacterElement.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/createCharacter.css">
    <style>
        textarea {
            overflow: hidden;
            overflow-y: auto;
            height: 250px;
        }

        .botones {
            background-color: white;
            display: flex;
            flex-direction: row;
            align-content: center;
            justify-content: space-evenly;
            align-items: center;
        }

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

        .none {
            padding-top: 0;
        }

        body {

            padding: 100px;
            padding-top: 0;
        }

        form {
            border-top: none;
            border-radius: 0px 0px 10px 10px;
        }
    </style>
</head>

<body>
    <div class="none">
        <nav>
            <ul class="nav-links">
                <li><a href="../home.php" class="button">Inicio</a></li>
                <li><a href="../Inventory/inventario.php" class="button">Gestionar inventario</a></li>
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
                <li><a href="../CharacterSheet/ficha.php" class="button">Ficha</a></li>
                <li><a href="../dice.php" class="button">Lanzar dados</a></li>
            </ul>
        </nav>

        <form method="post" action="process_updateCharacter.php">

            <div>
                <label name="exp">Experiencia</label>
                <input type="number" name="exp" id="exp"
                    value="<?php echo htmlspecialchars($character['experiencia']); ?>"
                    min="<?php echo htmlspecialchars($character['experiencia']); ?>" max="355000">

            </div>
            <div class="form-row">
                <div class="column">
                    <label name="HP">Puntos de golpe</label>
                    <input type="number" name="HP" id="HP" value="<?php echo htmlspecialchars($character['hp']); ?>"
                        min="<?php echo htmlspecialchars($character['hp']); ?>">
                </div>
                <div class="column">
                    <label name="gold">Oro</label>
                    <input type="number" name="gold" id="gold"
                        value="<?php echo htmlspecialchars($character['oro']); ?>" min="0">
                </div>

            </div>

            <div class="form-row">
                <div class="column">
                    <label for="languages">Idiomas y otras proficiencias</label>
                    <textarea name="languages"
                        id="languages"><?php echo htmlspecialchars($character['idiomas']); ?></textarea>
                </div>
                <div class="column">
                    <label for="personality">Personalidad</label>
                    <textarea name="personality"
                        id="personality"><?php echo htmlspecialchars($character['personalidad']); ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="column">
                    <label for="ideals">Ideales</label>
                    <textarea name="ideals"
                        id="ideals"><?php echo htmlspecialchars($character['ideales']); ?></textarea>
                </div>
                <div class="column">
                    <label for="bonds">Lazos</label>
                    <textarea name="bonds" id="bonds"><?php echo htmlspecialchars($character['lazos']); ?></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="column">
                    <label for="flaws">Defectos</label>
                    <textarea name="flaws" id="flaws"><?php echo htmlspecialchars($character['defectos']); ?></textarea>
                </div>
                <div class="column">
                    <label for="background">Historia</label>
                    <textarea name="background"
                        id="background"><?php echo htmlspecialchars($character['historia_personaje']); ?></textarea>
                </div>
            </div>


            <div>
                <h2>Asignación de puntos</h2>
                <b id="limite" style="display: none;">999</b>
                <table>
                    <thead>
                        <tr>
                            <th>Fuerza</th>
                            <th>Destreza</th>
                            <th>Constitución</th>
                            <th>Inteligencia</th>
                            <th>Sabiduría</th>
                            <th>Carisma</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="FuerzaB"></td>
                            <td id="DestrezaB"></td>
                            <td id="ConstituciónB"></td>
                            <td id="InteligenciaB"></td>
                            <td id="SabiduríaB"></td>
                            <td id="CarismaB"></td>
                        </tr>
                        <tr>
                            <td><button id="Fuerza_+">+</button></td>
                            <td><button id="Destreza_+">+</button></td>
                            <td><button id="Constitución_+">+</button></td>
                            <td><button id="Inteligencia_+">+</button></td>
                            <td><button id="Sabiduría_+">+</button></td>
                            <td><button id="Carisma_+">+</button></td>
                        </tr>
                        <tr>
                            <td id="Fuerza_base"><?php echo $character['fuerza']; ?></td>
                            <td id="Destreza_base"><?php echo $character['destreza']; ?></td>
                            <td id="Constitución_base"><?php echo $character['constitucion']; ?></td>
                            <td id="Inteligencia_base"><?php echo $character['inteligencia']; ?></td>
                            <td id="Sabiduría_base"><?php echo $character['sabiduria']; ?></td>
                            <td id="Carisma_base"><?php echo $character['carisma']; ?></td>
                        </tr>


                        <tr>
                            <td><button id="Fuerza_-">-</button></td>
                            <td><button id="Destreza_-">-</button></td>
                            <td><button id="Constitución_-">-</button></td>
                            <td><button id="Inteligencia_-">-</button></td>
                            <td><button id="Sabiduría_-">-</button></td>
                            <td><button id="Carisma_-">-</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="hidden">
                <input type="number" name="Fuerza_base_hidden" id="Fuerza_base_hidden">
                <input type="number" name="Destreza_base_hidden" id="Destreza_base_hidden">
                <input type="number" name="Constitución_base_hidden" id="Constitución_base_hidden">
                <input type="number" name="Inteligencia_base_hidden" id="Inteligencia_base_hidden">
                <input type="number" name="Sabiduría_base_hidden" id="Sabiduría_base_hidden">
                <input type="number" name="Carisma_base_hidden" id="Carisma_base_hidden">
                <input type="number" name="HP_hidden" id="HP_hidden">
            </div>
            <br><br>
            <div class="botones">
                <button type="submit">Actualizar personaje</button>
        </form>
        <!-- <form action="process_deleteCharacter.php" method="post" style="all: unset">
            <input type="number" name="delete_id" id="delete_id" style="display: none"
                value="<?php echo $_SESSION['Personaje_ID']; ?>">
            <button>Eliminar Personaje</button>
        </form> -->

        <button id="no_funciona">Eliminar Personaje</button>

    </div>

    <script src="../javascript/normalAddPoint.js"></script>
    <script src="../javascript/normalSubstractPoint.js"></script>
    <script src="../javascript/hiddenPoints.js"></script>
    <script src="../javascript/checkObject.js"></script>
    <script src="../javascript/showBonusPointOnLoad.js"></script>
    <script> document.getElementById('no_funciona').addEventListener('click', function () {
            event.preventDefault();
            alert('Ahora mismo el minion que se encarga de eliminar personajes se encuentra de vacaciones o fuera de cobertura. Deje su mensaje después de la señal. *PIP*');

        })</script>
    </div>
</body>

</html>