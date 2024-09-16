<?php
include '../security.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación</title>
    <link rel="stylesheet" href="../styles/normalize.css">
    <link rel="stylesheet" href="../styles/createCharacter.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
<style>
    form select, text, textarea {
        font-family: 'Roboto';
    }

    textarea{
        height: 150px;
    }
</style>

</head>

<body style="padding-top:0;">
    <form method="post" action="process_createCharacter.php" style="width: 80%;">
        <div>
            <label for="name">Introduce el nombre de tu personaje</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-row">
    <div class="column">
        <label for="raza">Elige la raza</label>
        <select name="raza" id="raza" onchange="calcularBonificaciones()" required>
            <option value="none" disabled selected>Selecciona una raza</option>
            <option value="Humano">Humano</option>
            <option value="Elfo">Elfo</option>
            <option value="Enano">Enano</option>
            <option value="Mediano">Mediano</option>
            <option value="Orco">Orco</option>
            <option value="Gnomo">Gnomo</option>
            <option value="Semielfo">Semielfo</option>
            <option value="Semiorco">Semiorco</option>
            <option value="Tiflin">Tiflin</option>
            <option value="Dracónido">Dracónido</option>
        </select>
    </div>

    <div class="column">
        <label for="clase">Elige la clase</label>
        <select name="clase" id="clase" onchange="checkHP()">
            <option value="none" disabled selected>Selecciona una clase</option>
            <option value="Bárbaro">Bárbaro</option>
            <option value="Guerrero">Guerrero</option>
            <option value="Paladín">Paladín</option>
            <option value="Explorador">Explorador</option>
            <option value="Bardo">Bardo</option>
            <option value="Clérigo">Clérigo</option>
            <option value="Druida">Druida</option>
            <option value="Monje">Monje</option>
            <option value="Pícaro">Pícaro</option>
            <option value="Brujo">Brujo</option>
            <option value="Hechicero">Hechicero</option>
            <option value="Mago">Mago</option>
        </select>
    </div>
</div>

<div class="form-row">
    <div class="column">
        <label for="transfondo">Elige el transfondo</label>
        <select name="transfondo" id="transfondo" onchange="obtenerHabilidades()" required>
            <option value="none" disabled selected>Selecciona un transfondo</option>
            <option value="Acólito">Acólito</option>
            <option value="Criminal">Criminal</option>
            <option value="Erudito">Erudito</option>
            <option value="Héroe del Pueblo">Héroe del Pueblo</option>
            <option value="Noble">Noble</option>
            <option value="Forastero">Forastero</option>
            <option value="Soldado">Soldado</option>
            <option value="Artista">Artista</option>
            <option value="Marinero">Marinero</option>
            <option value="Charlatán">Charlatán</option>
            <option value="Huérfano">Huérfano</option>
            <option value="Artesano del Gremio">Artesano del Gremio</option>
            <option value="Ermitaño">Ermitaño</option>
            <option value="Nómada">Nómada</option>
        </select>
    </div>

    <div class="column">
        <label for="alineamiento">Selecciona el alineamiento</label>
        <select name="alineamiento" id="alineamiento">
            <option value="none" disabled selected>Selecciona un alineamiento</option>
            <option value="Legal Bueno">Legal Bueno</option>
            <option value="Neutral Bueno">Neutral Bueno</option>
            <option value="Caótico Bueno">Caótico Bueno</option>
            <option value="Legal Neutral">Legal Neutral</option>
            <option value="Neutral Verdadero">Neutral Verdadero</option>
            <option value="Caótico Neutral">Caótico Neutral</option>
            <option value="Legal Malvado">Legal Malvado</option>
            <option value="Neutral Malvado">Neutral Malvado</option>
            <option value="Caótico Malvado">Caótico Malvado</option>
        </select>
    </div>
</div>


        <div>
            <h2>Asignación de puntos</h2>
            <p>Puntos de atributos disponibles: <b id="limite">27</b></p>
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
                        <td id="Fuerza_base">10</td>
                        <td id="Destreza_base">10</td>
                        <td id="Constitución_base">10</td>
                        <td id="Inteligencia_base">10</td>
                        <td id="Sabiduría_base">10</td>
                        <td id="Carisma_base">10</td>
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
        <div id="divHabilidad">
            <h2>Habilidades destacadas</h2>
            <p id="habilidades"></p>
        </div>
        <div>
            <h2 style="display: none;" id="hit">Puntos de vida: <b id="HP"></b></h2>
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
                    <label for="historia">Historia</label>
                    <textarea name="historia"
                        id="historia"><?php echo htmlspecialchars($character['historia_personaje']); ?></textarea>
                </div>
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
        <button type="submit">Crear personaje</button>
    </form>

    <script src="../javascript/addPoint.js"></script>
    <script src="../javascript/substractPoint.js"></script>
    <script src="../javascript/checkBonificaciones.js"></script>
    <script src="../javascript/checkAbilities.js"></script>
    <script src="../javascript/checkHP.js"></script>
    <script src="../javascript/hiddenPoints.js"></script>
    <script src="../javascript/checkObject.js"></script>
    <script src="../javascript/showBonusPointOnLoad.js"></script>

</body>

</html>