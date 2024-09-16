<?php
session_start();
include '../objetos.php';
include 'gestor_ficha.php';
include '../security.php';
if (!isset($_SESSION['Personaje_ID'])) {
  header('Location: ../home.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ficha de <?php echo $character['nombre']; ?></title>
  <link rel="stylesheet" href="../styles/normalize.css">
  <link rel="stylesheet" href="../styles/sheet.css">
  <style>
    .button {
      display: inline-block;
      padding: 10px 20px;
      margin: 5px;
      font-size: 16px;
      font-weight: bold;
      text-align: center;
      text-decoration: none;
      color: #fff;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }
    .button:hover {
      background-color: #0056b3;
    }
    .button:active {
      background-color: #004494;
    }
    nav {
      background-color: #333;
      padding: 10px;
      width: -webkit-fill-available;
      border-radius: 7px 7px 30px 30px;
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
    textarea {
      overflow: hidden;
    }
    textarea:hover * {
      overflow-y: scroll;
    }
    nav {
      border-radius: 7px 7px 0px 0px;
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
        <li><a href="../Character/updateCharacter.php" class="button">Editar personaje</a></li>
        <li><a href="../dice.php" class="button">Lanzar dados</a></li>
      </ul>
    </nav>
    <form class="charsheet">
      <header>
        <section class="charname">
          <label for="charname">Nombre del personaje</label>
          <input readonly readonly name="charname" value=<?php echo $character['nombre']; ?>>
        </section>
        <section class="misc">
          <ul>
            <li>
              <label for="classlevel">Clase y nivel</label><input readonly name="classlevel"
                value="<?php echo htmlspecialchars($character['clase'] . ', ' . $character['nivel']); ?>" />
            </li>
            <li>
              <label for="background">Transfondo</label><input readonly name="background"
                value="<?php echo htmlspecialchars($character['transfondo']); ?>" />
            </li>
            <li>
              <label for="playername">Nombre del jugador</label><input readonly name="playername"
                placeholder="Player McPlayerface" value="<?php echo htmlspecialchars(obtenerNombre()); ?>">
            </li>
            <li>
              <label for="race">Raza</label><input readonly name="race"
                value="<?php echo htmlspecialchars($character['raza']); ?>" />
            </li>
            <li>
              <label for="alignment">Alineamiento</label><input readonly name="alignment"
                value="<?php echo htmlspecialchars($character['alineamiento']); ?>" />
            </li>
            <li>
              <label for="experiencepoints">Puntos de experiencia</label><input readonly name="experiencepoints"
                value="<?php echo htmlspecialchars($character['experiencia']); ?>" />
            </li>
          </ul>
        </section>
      </header>
      <main>
        <section>
          <section class="attributes">
            <div class="scores">
              <ul>
                <li>
                  <div class="score">
                    <label for="Strengthscore">Fuerza</label>
                    <input readonly name="Strengthscore"
                      value="<?php echo htmlspecialchars($character['fuerza']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Strengthmod"
                      value="<?php echo htmlspecialchars(floor(($character['fuerza'] - 10) / 2)); ?>" />
                  </div>
                </li>
                <li>
                  <div class="score">
                    <label for="Dexterityscore">Destreza</label>
                    <input readonly name="Dexterityscore"
                      value="<?php echo htmlspecialchars($character['destreza']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Dexteritymod"
                      value="<?php echo htmlspecialchars(floor(($character['destreza'] - 10) / 2)); ?>" />
                  </div>
                </li>
                <li>
                  <div class="score">
                    <label for="Constitutionscore">Constitución</label>
                    <input readonly name="Constitutionscore"
                      value="<?php echo htmlspecialchars($character['constitucion']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Constitutionmod"
                      value="<?php echo htmlspecialchars(floor(($character['constitucion'] - 10) / 2)); ?>" />
                  </div>
                </li>
                <li>
                  <div class="score">
                    <label for="Wisdomscore">Sabiduría</label>
                    <input readonly name="Wisdomscore"
                      value="<?php echo htmlspecialchars($character['sabiduria']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Wisdommod"
                      value="<?php echo htmlspecialchars(floor(($character['sabiduria'] - 10) / 2)); ?>" />
                  </div>
                </li>
                <li>
                  <div class="score">
                    <label for="Intelligencescore">Inteligencia</label>
                    <input readonly name="Intelligencescore"
                      value="<?php echo htmlspecialchars($character['inteligencia']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Intelligencemod"
                      value="<?php echo htmlspecialchars(floor(($character['inteligencia'] - 10) / 2)); ?>" />
                  </div>
                </li>
                <li>
                  <div class="score">
                    <label for="Charismascore">Carisma</label>
                    <input readonly name="Charismascore"
                      value="<?php echo htmlspecialchars($character['carisma']); ?>" />
                  </div>
                  <div class="modifier">
                    <input readonly name="Charismamod"
                      value="<?php echo htmlspecialchars(floor(($character['carisma'] - 10) / 2)); ?>" />
                  </div>
                </li>
              </ul>
            </div>
            <div class="attr-applications">
              <div class="inspiration box">
                <div class="label-container">
                  <label for="inspiration">Inspiración</label>
                </div>
                <input name="inspiration" type="checkbox" />
              </div>
              <div class="proficiencybonus box">
                <div class="label-container">
                  <label for="proficiencybonus">Bonos de competencia</label>
                </div>
                <input readonly name="proficiencybonus" value="<?php
                if ($character['nivel'] < 5) {
                  echo '+2';
                } else if ($character['nivel'] < 9) {
                  echo '+3';
                } else if ($character['nivel'] < 13) {
                  echo '+4';
                } else if ($character['nivel'] < 17) {
                  echo '+5';
                } else {
                  echo '+6';
                }
                ?>" />
              </div>
              <div class="saves list-section box">
                <ul>
                  <li>
                    <label for="Strength-save">Fuerza</label><input readonly name="Strength-save" type="text" /><input
                      readonly name="Strength-save-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Dexterity-save">Destreza</label><input readonly name="Dexterity-save"
                      type="text" /><input readonly name="Dexterity-save-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Constitution-save">Constitución</label><input readonly name="Constitution-save"
                      type="text" /><input readonly name="Constitution-save-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Wisdom-save">Sabiduría</label><input readonly name="Wisdom-save" type="text" /><input
                      readonly name="Wisdom-save-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Intelligence-save">Inteligencia</label><input readonly name="Intelligence-save"
                      type="text" /><input readonly name="Intelligence-save-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Charisma-save">Carisma</label><input readonly name="Charisma-save" type="text" /><input
                      readonly name="Charisma-save-prof" type="checkbox" />
                  </li>
                </ul>
                <div class="label">
                  Salvación
                </div>
              </div>
              <div class="skills list-section box">
                <ul>
                  <li>
                    <label for="Acrobatics">Acrobacias <span class="skill">(Des)</span></label><input readonly
                      name="Acrobatics" value="<?php echo htmlspecialchars($character['acrobacias']); ?>"
                      type="text" /><input readonly name="Acrobatics-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Animal Handling">Trato con animales <span class="skill">(Sab)</span></label><input
                      readonly name="Animal Handling"
                      value="<?php echo htmlspecialchars($character['trato_con_animales']); ?>" type="text" /><input
                      readonly name="Animal Handling-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Arcana">Arcano <span class="skill">(Int)</span></label><input readonly name="Arcana"
                      value="<?php echo htmlspecialchars($character['arcano']); ?>" type="text" /><input readonly
                      name="Arcana-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Athletics">Atletismo <span class="skill">(Fue)</span></label><input readonly
                      name="Athletics" value="<?php echo htmlspecialchars($character['atletismo']); ?>"
                      type="text" /><input readonly name="Athletics-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Deception">Engaño <span class="skill">(Car)</span></label><input readonly
                      name="Deception" value="<?php echo htmlspecialchars($character['engaño']); ?>"
                      type="text" /><input readonly name="Deception-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="History">Historia <span class="skill">(Int)</span></label><input readonly name="History"
                      value="<?php echo htmlspecialchars($character['historia']); ?>" type="text" /><input readonly
                      name="History-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Insight">Perspicacia <span class="skill">(Sab)</span></label><input readonly
                      name="Insight" value="<?php echo htmlspecialchars($character['perspicacia']); ?>"
                      type="text" /><input readonly name="Insight-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Intimidation">Intimidación <span class="skill">(Car)</span></label><input readonly
                      name="Intimidation" value="<?php echo htmlspecialchars($character['intimidacion']); ?>"
                      type="text" /><input readonly name="Intimidation-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Investigation">Investigación <span class="skill">(Int)</span></label><input readonly
                      name="Investigation" value="<?php echo htmlspecialchars($character['investigacion']); ?>"
                      type="text" /><input readonly name="Investigation-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Medicine">Medicina<span class="skill">(Sab)</span></label><input readonly
                      name="Medicine" value="<?php echo htmlspecialchars($character['medicina']); ?>"
                      type="text" /><input readonly name="Medicine-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Nature">Naturaleza <span class="skill">(Int)</span></label><input readonly name="Nature"
                      value="<?php echo htmlspecialchars($character['naturaleza']); ?>" type="text" /><input readonly
                      name="Nature-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Perception">Percepción <span class="skill">(Sab)</span></label><input readonly
                      name="Perception" value="<?php echo htmlspecialchars($character['percepcion']); ?>"
                      type="text" /><input readonly name="Perception-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Performance">Interpretación <span class="skill">(Car)</span></label><input readonly
                      name="Performance" value="<?php echo htmlspecialchars($character['interpretacion']); ?>"
                      type="text" /><input readonly name="Performance-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Persuasion">Persuasión <span class="skill">(Car)</span></label><input readonly
                      name="Persuasion" value="<?php echo htmlspecialchars($character['persuasión']); ?>"
                      type="text" /><input readonly name="Persuasion-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Religion">Religión <span class="skill">(Int)</span></label><input readonly
                      name="Religion" value="<?php echo htmlspecialchars($character['religion']); ?>"
                      type="text" /><input readonly name="Religion-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Sleight of Hand">Juego de manos <span class="skill">(Des)</span></label><input readonly
                      name="Sleight of Hand" value="<?php echo htmlspecialchars($character['juego_de_manos']); ?>"
                      type="text" /><input readonly name="Sleight of Hand-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Stealth">Sigilo <span class="skill">(Des)</span></label><input readonly name="Stealth"
                      value="<?php echo htmlspecialchars($character['sigilo']); ?>" type="text" /><input readonly
                      name="Stealth-prof" type="checkbox" />
                  </li>
                  <li>
                    <label for="Survival">Supervivencia <span class="skill">(Sab)</span></label><input readonly
                      name="Survival" value="<?php echo htmlspecialchars($character['supervivencia']); ?>"
                      type="text" /><input readonly name="Survival-prof" type="checkbox" />
                  </li>
                </ul>
                <div class="label">
                  Habilidades
                </div>
              </div>
            </div>
          </section>
          <div class="passive-perception box">
            <div class="label-container">
              <label for="passiveperception">Sabiduría Pasiva (Percepción)</label>
            </div>
            <input readonly name="passiveperception"
              value="<?php echo htmlspecialchars(floor(($character['sabiduria'] - 10) / 2) + 10 + $character['sabiduria']) ?>" />
          </div>
          <div class="otherprofs box textblock">
            <label for="otherprofs">Idiomas y otras proficiencias</label><textarea
              name="otherprofs"><?php echo htmlspecialchars($character['idiomas']); ?></textarea>
          </div>
        </section>
        <section>
          <section class="combat">
            <div class="armorclass">
              <div>
                <label for="ac">Clase Armaduda</label><input readonly name="ac"
                  value="<?php echo htmlspecialchars(clase_armadura($character['destreza'])); ?>" type="text" />
              </div>
            </div>
            <div class="initiative">
              <div>
                <label for="initiative">Iniciativa</label><input readonly name="initiative"
                  value="<?php echo htmlspecialchars($character['iniciativa']); ?>" type="text" />
              </div>
            </div>
            <div class="speed">
              <div>
                <label for="speed">Velocidad</label><input readonly name="speed"
                  value="<?php echo htmlspecialchars($character['velocidad']); ?>" type="text" />
              </div>
            </div>
            <div class="gold" style="flex-basis: 100%;">
              <div>
                <label for="gold">Oro</label><input readonly name="gold"
                  value="<?php echo htmlspecialchars($character['oro']); ?>" type="text" />
              </div>
            </div>
            <div class="hp">
              <div class="regular">
                <div class="max">
                  <label for="maxhp">Puntos de vida máximos</label><input readonly name="maxhp"
                    value="<?php echo htmlspecialchars($character['hp']); ?>" type="text" />
                </div>
                <div class="current">
                  <label for="currenthp">Puntos de vida actuales</label><input name="currenthp" type="text" />
                </div>
              </div>
              <div class="temporary">
                <label for="temphp">Puntos de vida temporales</label><input name="temphp" type="text" />
              </div>
            </div>
            <div class="deathsaves">
              <div>
                <div class="label">
                  <label>Salvación</label>
                </div>
                <div class="marks">
                  <div class="deathsuccesses">
                    <label>Éxitos</label>
                    <div class="bubbles">
                      <input readonly name="deathsuccess1" type="checkbox" />
                      <input readonly name="deathsuccess2" type="checkbox" />
                      <input readonly name="deathsuccess3" type="checkbox" />
                    </div>
                  </div>
                  <div class="deathfails">
                    <label>Fracasos</label>
                    <div class="bubbles">
                      <input readonly name="deathfail1" type="checkbox" />
                      <input readonly name="deathfail2" type="checkbox" />
                      <input readonly name="deathfail3" type="checkbox" />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section class="attacksandspellcasting">
            <div>
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
                echo '<label>Hechizos</label>';
                obtenerHechizosSimple();
              } else {
                echo '<label>Ataques</label>';
                echo '<textarea style="height: 500px;"></textarea>';
              }
              ?>
            </div>
          </section>
        </section>
        <section>
          <section class="flavor">
            <div class="personality">
              <label for="personality">Personalidad</label><textarea
                name="personality"><?php echo htmlspecialchars($character['personalidad']) ?></textarea>
            </div>
            <div class="ideals">
              <label for="ideals">Ideales</label><textarea
                name="ideals"><?php echo htmlspecialchars($character['ideales']) ?></textarea>
            </div>
            <div class="bonds">
              <label for="bonds">Lazos</label><textarea
                name="bonds"><?php echo htmlspecialchars($character['lazos']) ?> </textarea>
            </div>
            <div class="flaws">
              <label for="flaws">Defectos</label><textarea
                name="flaws"><?php echo htmlspecialchars($character['defectos']) ?> </textarea>
            </div>
          </section>
          <section class="features">
            <div>
              <label for="features">Historia</label><textarea
                name="features"><?php echo htmlspecialchars($character['historia_personaje']) ?></textarea>
            </div>
          </section>
        </section>
      </main>
      <section class="macarena">
        <div style="width: 90%;">
          <label
            style="display: flex;font-size:medium;margin-top:15px;justify-content:center;"><b>Equipamiento</b></label>
          <?php
          obtenerEquipoFicha();
          ?>
        </div>
      </section>
    </form>
  </div>
</body>
</html>